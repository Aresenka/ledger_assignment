# Introduction
This is a simple ledger API with only three endpoints: 
- GET /api/v1/account/{id}/info
- GET /api/v1/account/{id}/transactions
- POST /api/v1/transaction/new

## Getting started
1. Install **docker** (or **docker desktop**) and **composer**;
2. From the project root, run `docker-compose build`;
3. After successful build, run `docker-compose up -d`;
4. Create a `.env` file from the `.env.example` in the root folder and fill it with actual values;
5. From **docker desktop**, enter the `app` terminal (or run `docker exec -ti app bash`);
6. Run `php artisan key:generate`;
7. Run `composer install`;
8. Run `php artisan migrate --seed`;
9. Reach any endpoints using `localhost:8100` as a domain name.

## Creating a transaction
Transaction must contain:
- transfer_from - int - account id to send funds from;
- transfer_to - int - account id to send funds to;
- amount - int - amount of minimal units of the currency (e.g. satoshi);
- currency - int - currency id (1 for BTC, 2 for ETH after seeding);
- idempotency_key - string - any unique 20 letters long string.

No auth required, enjoy!