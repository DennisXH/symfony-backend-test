Run `docker-compose up -d app mysql` to start the server

Root URL `localhost:8000`

Run Tests `docker-compose run --rm tool ./vendor/bin/phpunit tests`

General instructions:
- All requests should return either 2XX (for successfull requests) or 4xx (for failed requests) HTTP status code
- All endpoints must return a well-formed JSON object
- Keep in mind coding best practices (security, modularity, simplicity, etc) as well as code/SQL performance
- /users/sign-up is the only endpoint open to the public
- All fields on each endpoint are REQUIRED unless otherwise stated
- You're free to modify the existing tables in any way and/or create new ones
- You're free to modify the code provided in any way
- Session tokens (if present) are sent on the "Authentication" header, and stored on the BaseController class

1 - Create a database connection

2 - POST | /users/sign-up | Create new accounts
    - Response 1: {"success":true, "session_token": "09as8kd0m9a8dmd89d"}
    - Response 2: {"success":false}

3 - POST | /users/login | Used for existing users to login
    - Response 1: {"success":true, "session_token": "89amn7sd98as7nda97"}
    - Response 2: {"success":false}

4 - POST | /purchases/purchase | Attempts to purchase a coin package
    - Response 1: {"success":true}
    - Response 2: {"success":false}

5 - GET | /purchases/get | For a given user, list all purchases or return a specific purchase
    - Response 1: [[{"purchase_token":"9as8d98sa7dsajm98d","created_at":"2020-10-01 01:51:31","currency":"USD","coin_package_id":1},{"purchase_token":"09as8dm8sa9nd7j89a","created_at":"2020-10-02 01:51:31","currency":"USD","coin_package_id":1}]]
    - Response 2: [{"purchase_token":"9as8d98sa7dsajm98d","created_at":"2020-10-01 01:51:31","currency":"USD","coin_package_id":2}]

6 - Write the unit and/or functional tests you DEEM NECESSARY.

7 - Please provide a url for testing, and send back the code as well as a mysqldump.