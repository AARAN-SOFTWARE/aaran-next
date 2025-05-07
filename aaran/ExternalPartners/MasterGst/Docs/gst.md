```
    curl -X GET "https://api.mastergst.com/einvoice/authenticate?email=aaranoffice%40gmail.com" -H "accept: */*" -H "
    username: mastergst" -H "password: Malli#123" -H "ip_address: 103.231.117.198" -H "client_id:
    7428e4e3-3dc4-45dd-a09d-78e70267dc7b" -H "client_secret: 79a7b613-cf8f-466f-944f-28b9c429544d" -H "gstin:
    29AABCT1332L000"
```

Response body

```
    {
    "data": {
    "UserName": "mastergst",
    "TokenExpiry": "2025-05-05 10:30:00",
    "Sek": "8KJ9feQLMOUrNIMglpKKxPlQ4Tp4n0xEqAb5Wy2hxoZfFIFgNlVMDrG37eBBXqRs",
    "ClientId": "AABCT29GSPS57O5",
    "AuthToken": "1N8HdYZAHvcRudu46VHj8pFcT"
    },
    "status_cd": "Sucess",
    "status_desc": "GSTR request succeeds",
    "header": {
    "sec-ch-ua-platform": "\"Windows\"",
    "sec-ch-ua": "\"Google Chrome\";v=\"135\", \"Not-A.Brand\";v=\"8\", \"Chromium\";v=\"135\"",
    "ip_address": "103.231.117.198",
    "client_id": "7428e4e3-3dc4-45dd-a09d-78e70267dc7b",
    "sec-ch-ua-mobile": "?0",
    "username": "mastergst",
    "gstin": "29AABCT1332L000",
    "client_secret": "79a7b613-cf8f-466f-944f-28b9c429544d",
    "password": "Malli#123",
    "sec-fetch-site": "same-site",
    "sec-fetch-mode": "cors",
    "sec-fetch-dest": "empty",
    "priority": "u=1, i",
    "gst_username": "mastergst",
    "txn": "a53246e79dae43848f2820f5f2293366"
    }
    }
```
```
array:5 [▼ // aaran\ExternalPartners\MasterGst\Livewire\Class\Authenticate.php:28
"UserName" => "mastergst"
"TokenExpiry" => "2025-05-05 14:30:00"
"Sek" => "ZU9oMx3PqnCLDtJ2FD038epFpaVDrf4IfMnWdEMfDE7r+qVFnzTxEYoeOc6LffAb"
"ClientId" => "AABCT29GSPS57O5"
"AuthToken" => "1I9T7uK07ecP5Vd8mj30mhZMn"
]
```
