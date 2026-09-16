<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Models\SupportNotification;
use Illuminate\Database\Eloquent\Collection;

class SupportNotificationService
{
    public static function getActiveEmails(): array
    {
        $emails = SupportNotification::where('status', 'Active')
            ->pluck('email')
            ->filter()
            ->values()
            ->toArray();

        if (empty($emails)) {
            $emails = [config('mail.customer_support_mail')];
        }

        return $emails;
    }

    public static function list(): Collection
    {
        return SupportNotification::orderByDesc('id')->get();
    }

    /**
     * @throws CustomException
     */
    public static function fetch(int $id): SupportNotification
    {
        $notification = SupportNotification::find($id);
        if (! $notification) {
            throw new CustomException('Support notification not found', 404);
        }

        return $notification;
    }

    /**
     * @throws CustomException
     */
    public static function create(array $data): SupportNotification
    {
        $exists = SupportNotification::where('email', strtolower($data['email']))->exists();
        if ($exists) {
            throw new CustomException('A support notification with this email already exists', 422);
        }

        return SupportNotification::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => strtolower($data['email']),
            'status' => $data['status'] ?? 'Active',
        ]);
    }

    /**
     * @throws CustomException
     */
    public static function update(array $data, int $id): SupportNotification
    {
        $notification = self::fetch($id);

        if (isset($data['email']) && strtolower($data['email']) !== $notification->email) {
            $exists = SupportNotification::where('email', strtolower($data['email']))
                ->where('id', '!=', $id)
                ->exists();
            if ($exists) {
                throw new CustomException('A support notification with this email already exists', 422);
            }
        }

        $notification->update(array_filter([
            'firstname' => $data['firstname'] ?? null,
            'lastname' => $data['lastname'] ?? null,
            'email' => isset($data['email']) ? strtolower($data['email']) : null,
            'status' => $data['status'] ?? null,
        ], fn ($v) => $v !== null));

        return $notification->fresh();
    }

    /**
     * @throws CustomException
     */
    public static function activate(int $id): SupportNotification
    {
        $notification = self::fetch($id);
        $notification->update(['status' => 'Active']);

        return $notification->fresh();
    }

    /**
     * @throws CustomException
     */
    public static function deactivate(int $id): SupportNotification
    {
        $notification = self::fetch($id);

        $activeCount = SupportNotification::where('status', 'Active')->count();
        if ($activeCount <= 1) {
            throw new CustomException('Cannot deactivate the last active support notification', 422);
        }

        $notification->update(['status' => 'Inactive']);

        return $notification->fresh();
    }

    /**
     * @throws CustomException
     */
    public static function delete(int $id): void
    {
        $notification = self::fetch($id);

        $activeCount = SupportNotification::where('status', 'Active')->count();
        if ($activeCount <= 1 && $notification->status === 'Active') {
            throw new CustomException('Cannot delete the last active support notification', 422);
        }

        $notification->delete();
    }
}
