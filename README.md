# symfony-issue-32410
A reproducer for Symfony bug regarding Form CollecionType and validation errors not able to appear on the correct embedded form fields

https://github.com/symfony/symfony/issues/32410

https://github.com/symfony/symfony/pull/39438 

https://github.com/symfony/symfony/pull/22867 


To get up and running
1. Edit .env to your DB of choice
2. composer install
3. yarn install
4. yarn add stimulus --dev
5. yarn dev
6. symfony server:start --no-tls
7. goto localhost:8000/parent/index

Latest commit is a working example
