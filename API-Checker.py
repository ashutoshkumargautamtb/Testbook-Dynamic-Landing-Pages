import requests
import json

# Define the URL with query parameters
url = "https://api.testbook.com/api/v2/mobile/signup"
params = {
    "mobile": "7827046470",
    "clientId": "1247508708.1718728785",
    "sessionId": "1726813769"
}

# Define headers
headers = {
    "accept": "application/json, text/plain, */*",
    "accept-language": "en-GB,en-US;q=0.9,en;q=0.8",
    "content-type": "application/json",
    "origin": "https://testbook.com",
    "priority": "u=1, i",
    "referer": "https://testbook.com/",
    "sec-ch-ua": '"Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"',
    "sec-ch-ua-mobile": "?0",
    "sec-ch-ua-platform": '"macOS"',
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-site",
    "user-agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36",
    "x-tb-client": "web,1.2"
}

# Define the JSON body
data = {
    "firstVisitSource": {
        "type": "typein",
        "utm_source": "(direct)",
        "timestamp": "2024-06-19T06:47:29.000Z",
        "entrance": "https://testbook.com/"
    },
    "signupSource": {},
    "mobile": "7827046470",
    "signupDetails": {
        "page": "SuperCoachingExam-RRB JE (Civil) Guaranteed Selection Program 2024",
        "pagePath": "/rrb-je-coaching",
        "pageType": "SuperCoachingExamPage"
    }
}

# Send the POST request
response = requests.post(url, params=params, headers=headers, data=json.dumps(data))

# Print the response
if response.status_code == 200:
    print("Success:", response.json())
else:
    print(f"Failed with status code {response.status_code}: {response.text}")
