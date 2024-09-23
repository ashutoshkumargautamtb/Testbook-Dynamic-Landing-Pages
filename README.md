# All India IIT & JEE TEST By Testbook

---

    This is Landing page for test ( All india IIT - JEE TEST)

    Used Programming languages are : 

    Frontend : HTML, CSS, JAVASCRIPT 

    Backend : PHP

---

    SMS Auth on this landing page.

---

    Database - Mysql (Using PHP)

---

# All India IIT & JEE TEST Exam By Testbook


    SMS - Server Cred
    
    66d9a2d0d6fc054d9457e433
    
    1107172553470675487

<hr>

    SMS TEXT 

    ##var1## is your one-time password (OTP) to ##var2## in ##var3## Testbook.
    Regards, Testbook

<hr>

    Web Engage

    Fire new event for a user (with exsiting user details.)

    
    API LISts

    https://asia-south1-testbook-app.cloudfunctions.net/webEnegagePushCampaign


    API KEY OF WEB ENGAGE 

    78ac5485-3067-4403-bb13-b367becdea16





-- IN HOUSE API (FOR SENDING SMS TO USER AND VERIFY USERS SO WE CAN DUMP AND OUR DATABASE.)


    -- For creating user and send OTP

    curl 'https://api.testbook.com/api/v2/mobile/signup?mobile=8860878080&clientId=1247508708.1718728785&sessionId=1726813769' \
    -H 'accept: application/json, text/plain, */*' \
    -H 'accept-language: en-GB,en-US;q=0.9,en;q=0.8' \
    -H 'content-type: application/json' \
    -H 'origin: https://testbook.com' \
    -H 'priority: u=1, i' \
    -H 'referer: https://testbook.com/' \
    -H 'sec-ch-ua: "Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"' \
    -H 'sec-ch-ua-mobile: ?0' \
    -H 'sec-ch-ua-platform: "macOS"' \
    -H 'sec-fetch-dest: empty' \
    -H 'sec-fetch-mode: cors' \
    -H 'sec-fetch-site: same-site' \
    -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36' \
    -H 'x-tb-client: web,1.2' \
    --data-raw '{"firstVisitSource":{"type":"typein","utm_source":"(direct)","timestamp":"2024-06-19T06:47:29.000Z","entrance":"https://testbook.com/"},"signupSource":{},"mobile":"8860878080","signupDetails":{"page":"SuperCoachingExam-RRB JE (Civil) Guaranteed Selection Program 2024","pagePath":"/rrb-je-coaching","pageType":"SuperCoachingExamPage"}}'





-- For OTP validate and login

    curl 'https://api.testbook.com/api/v2/otp/login?client=web&emailOrMobile=8860878080&otp=517325&refLink=&browserFpId=fakefp3479234814484&tbDeviceId=fakefp3479234814484&clientId=1247508708.1718728785&sessionId=1726813769' \
    -H 'accept: application/json, text/plain, */*' \
    -H 'accept-language: en-GB,en-US;q=0.9,en;q=0.8' \
    -H 'content-type: application/json' \
    -H 'origin: https://testbook.com' \
    -H 'priority: u=1, i' \
    -H 'referer: https://testbook.com/' \
    -H 'sec-ch-ua: "Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"' \
    -H 'sec-ch-ua-mobile: ?0' \
    -H 'sec-ch-ua-platform: "macOS"' \
    -H 'sec-fetch-dest: empty' \
    -H 'sec-fetch-mode: cors' \
    -H 'sec-fetch-site: same-site' \
    -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36' \
    -H 'x-tb-client: web,1.2' \
    --data-raw '{"firstVisitSource":{"type":"typein","utm_source":"(direct)","timestamp":"2024-06-19T06:47:29.000Z","entrance":"https://testbook.com/"},"signupSource":{},"emailOrMobile":"8860878080","otp":"517325","signupDetails":{"page":"SuperCoachingExam-RRB JE (Civil) Guaranteed Selection Program 2024","pagePath":"/rrb-je-coaching","pageType":"SuperCoachingExamPage"}}'