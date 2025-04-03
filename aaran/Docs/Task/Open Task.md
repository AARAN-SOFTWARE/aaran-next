# ** Notes **

# copy and fix from asset to Ui folder and rename aaran-ui to Ui - U as capital
# note all ui component related to be inside Ui->resources->components folder
     then only works as component for laravel
        - by - sundar - 27-03-2025

# Copy the followings from BMS and make it work with test and visual - 27-03-2025
- once complete reply on this note itself
- follow the workflow method

# Job -1 Common models
- City - @sundar - Completed ✅
- State - @Hari - Completed ✅
- Country - @Hari - Completed ✅
- Pincode - @Hari - Completed ✅
- District - @Hari - Not avilable in Aaran BMS
- AccountType - @Hari - Completed ✅
- Bank - @Saran - Completed ✅
- Category - @Saran - Completed ✅
- Colour - @Saran - Completed ✅
- ContactType - @Saran - Completed ✅
- Department - @Saran - Completed ✅
- Dispatch - @Srihari - completed ✅ on 27.03.2025
- Gst - @Srihari - completed ✅ on 27.03.2025
- Hsncode - @Srihari - completed ✅ on 27.03.2025
- PaymentMode - @Srihari - completed  ✅ on 27.03.2025
- ReceiptType - @Srihari - completed  ✅ on 27.03.2025
- Size
- TransactionType
- Transport
- Unit


# Job -2 Website models
- Home - @muthukumaran
- About - @muthukumaran
- Service - @muthukumaran
- Contact - @muthukumaran
- Blog - @muthukumaran


# Job -3 Common models
- refactor all common models according to tenant base service
- changes in model, livewire class and views check git #28 working tenant based city list
- work on this create two tables as tenant 
- tenant_1
- tenant_2
- run php artisan migrate:fresh --seed first and
- run php artisan aaran:migrate tenant_1 --fresh --seed and
- run php artisan aaran:migrate tenant_2 --fresh --seed and
- login with devone@aaran.org for first tenant_1 and for
- login with devtwo@aaran.org for first tenant_1 and for
- test all parameters visually like
- http://127.0.0.1:8000/cities
- create, edit, delete, change active  new city in first user devone
- check the same for devtwo
