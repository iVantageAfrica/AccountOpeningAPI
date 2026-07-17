# Imperial Account Opening API

This document provides sample requests and responses for the Imperial Account Opening API and the Internet Banking (S2S) registration API.

## Imperial Account Opening

### Sample Request

```json
{
  "FirstName": "John",
  "LastName": "Doe",
  "BVN": "22123456789",
  "DOB": "1990-01-01",
  "Address": "123 Sample Street, Ikeja, Lagos",
  "AccountType": "005",
  "Gender": "M",
  "PhoneNumber": "08012345678",
  "Email": "john.doe@example.com"
}
```

### Sample Response

```json
{
  "status": "success",
  "data": {
    "accountNo": "0000000000",
    "accountDesc": "JOHN DOE",
    "cusID": "00000000",
    "accountType": "Savings",
    "currDesc": "Nigerian Naira",
    "accountStatus": "1",
    "accountStatusDesc": "Active",
    "postStatus": "2",
    "postStatusDesc": "Post No Debit"
  },
  "message": null,
  "errorCode": null
}
```

### Response Fields

| Field | Description |
|--------|-------------|
| `status` | Status of the request (`success` or `failed`). |
| `data.accountNo` | Newly created account number. |
| `data.accountDesc` | Account holder's full name. |
| `data.cusID` | Unique customer identifier. |
| `data.accountType` | Type of account created. |
| `data.currDesc` | Account currency. |
| `data.accountStatus` | Account status code. |
| `data.accountStatusDesc` | Description of the account status. |
| `data.postStatus` | Posting status code. |
| `data.postStatusDesc` | Description of the posting status. |
| `message` | Additional information returned by the API. Usually `null` on success. |
| `errorCode` | Error code returned by the API. Usually `null` on success. |

---

# Internet Banking (S2S) Registration

The Internet Banking (S2S) service is called immediately after a successful account opening to provision Internet Banking credentials for the customer.

### Sample Request

```json
{
  "customer_code": "00000000",
  "firstname": "John",
  "surname": "Doe",
  "email": "john.doe@example.com",
  "phone": "08012345678",
  "pin": "1234"
}
```

### Sample Response

```json
{
  "success": true,
  "message": "Account created successfully.",
  "data": {
    "user_id": "AbC123XyZ",
    "password": "P@ssw0rd123"
  }
}
```

### Response Fields

| Field | Description |
|--------|-------------|
| `success` | Indicates whether the Internet Banking account was successfully created. |
| `message` | Response message returned by the S2S service. |
| `data.user_id` | Unique identifier of the Internet Banking user. |
| `data.password` | Generated temporary password for the Internet Banking account. |

> **Note:** The customer's **email address** is used as the Internet Banking username. The S2S service returns only the generated password and internal user ID.

---

## Example Success Response

```text
Imperial Account Opening
------------------------
Status          : Success
Account Number  : 0000000000
Customer ID     : 00000000
Account Name    : JOHN DOE
Account Type    : Savings
Currency        : Nigerian Naira
Account Status  : Active
Posting Status  : Post No Debit

Internet Banking (S2S)
-----------------------
Username        : john.doe@example.com
PIN             : 1234
Password        : P@ssw0rd123
Status          : Account created successfully.
```
