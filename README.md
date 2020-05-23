# Aspireapp
A mini version of Aspire app.  This is code challenge test before techincal interviewing of Aspire company.  
This App requires: `PHP 7.2.5`, `Composer` 
# Set up
Make sure to do the following steps to set up the app.  
* Run command `composer install` to install all dependencies.  
* Database: this app is using `sqlite` database to help you easier in setting up. You don't need to configure database, the system configured already. The database is placed at `db/aspireapp.db `.  
* Run `php bin/console doctrine:migrations:migrate` to migrate database table structure.  
* Run `php bin/console doctrine:fixtures:load` to init login info. This command will create 2 users for the system. They are:  
* > `demo@aspireapp.com / pwd123` --> Normal user.  
* > `admin@aspireapp.com / adminpwd123` --> Admin user.

* Run: `php -S 127.0.0.1:8000 -t public`  to start the web server. You can access web server with URL: `http://localhost:8000`.  
** If you got any problem with port 8000. Please choose another free port on your PC.  
# Configuration
I tried to make the system can be configurable as much as possible.
## Payment frequency
We might have many types of `repayment frequency`. They might be: monthly, fortnightly, yearly...  
Currently, system is supporting for `Weekly repayment` frequency. You can integrate other type by changing the value of `$loan->repaymentFrequency`.  
We are using `App\Service\Repayment\RepaymentService` to handle all business of repayment.  
This service will detect which type of `repayment frequency` is using and then using the corresponding Strategy to process  
To add `Monthly repayment` into system:   
* Set value of $loan: `$loan->setRepaymentFrequency(Loan::REPAYMENT_MONTHLY)`.
* Create class `MonthlyRepayment` to handle monthly behavior and override all abstract methods
```

namespace App\Service\Repayment;


use App\Entity\Loan;

class MonthlyRepayment extends RepaymentStrategy
{
    public function calculateAmount(Loan $loan): float
    {
        // TODO: Implement calculateAmount() method.
    }

    public function getNextRepaymentDate(Loan $loan): \DateTime
    {
        // TODO: Implement getNextRepaymentDate() method.
    }

}
```
* Register `MonthlyRepayment` as a service in `config/services.yaml`.  
```
services:
    ...
    app.service.repayment.mothly:
        class: App\Service\Repayment\MonthRepayment
    ...
```
* Integrate `MonthlyRepayment` into `RepaymentService` in  `config/services.yaml`.  
```
services:
    ...
    app.service.repayment.mothly:
        class: App\Service\Repayment\MonthRepayment
    ...
    
    App\Service\Repayment\RepaymentService:
        arguments:
            $repaymentStrategies:
                # loan.paymentFrequency: RepaymentStrategyServiceAlias
                1: '@app.service.repayment.weekly'
                3: '@app.service.repayment.mothly'
```
## Interest rate
Currently, system is supporting interest rate per month
We can add more interest rate such as: interest rate per year, flat interest rate, interest rate reduce base loan amount left.
Just modify `InterestRateService` and do like the idea of `Payment frequency`
# Unit test
So sorry i don't have enough time to deal with unit test. Let me have a chance to talk at the technical interview
# System explanation
We have 2 types of user. They are normal and admin users.
## Normal user
* User can log in to the app with this credential: `demo@aspireapp.com / pwd123`.    
* After logging in success, user will be redirected to `My Loans` page. This page displays all loans application of current user.   
* User can register a new loan application by clicking button `Register new loan application`
 ![image](https://user-images.githubusercontent.com/10457634/82736038-c964ea80-9d50-11ea-8041-05f0f6c0b772.png)
 * Enter loan information to register a new loan
 ![image](https://user-images.githubusercontent.com/10457634/82736102-324c6280-9d51-11ea-9ced-359edb2f1c6b.png)
 * After registering, the loan application status will be `New`. We will wait until the admin approve this loan application.  
 * All the loans will be assumed to have a “weekly” repayment frequency.  
 * To Repay: go to `My Loans` page, click `show` button on the specific loan. Then press button `Repay`. Please remember: button `Repay` just appears when status is approved
 * User can see the summary of loan reppayments, loan detail, loan repayment history on this page  
 ![image](https://user-images.githubusercontent.com/10457634/82736444-126a6e00-9d54-11ea-8b25-3dfcf971e8a9.png)
## Admin user
* Admin can log in to the app with this credential: `admin@aspireapp.com / adminpwd123`.    
* After logging in success, user will be redirected to `Loans list` page. This page displays all loans application.
![image](https://user-images.githubusercontent.com/10457634/82736577-0fbc4880-9d55-11ea-8477-f821d5bb3cad.png)
* Admin can approve or change a loan application by clicking `Edit` on specific loan
* Admin can see the list of latest `Loan Repayments` by clicking on each top menu
* Admin can approve a `Loan repayment` by clicking button `Approve` on specific `Loan Repayment`
![image](https://user-images.githubusercontent.com/10457634/82736710-f667cc00-9d55-11ea-83cb-8edf30b67faa.png)
 
