## // 09-04-2025 //
## Common
- Pin Code -> When I try to save an empty input, it doesn't show an error message.✅
- Country -> When I try to save an empty input, it doesn't show an error message.✅
- Unit -> When I try to save an empty input, it doesn't show an error message.  &  There is no input field to create a description.✅
- Category -> When I try to save an empty input, it doesn't show an error message.✅
- Colour -> When I try to save an empty input, it doesn't show an error message.✅
- Size -> There is no place for the description in the table.✅
- Department -> When I try to save an empty input, it doesn't show an error message.✅
- Bank -> When I try to save an empty input, it doesn't show an error message.✅
- Receipt Type -> When I try to save an empty input, it doesn't show an error message.✅
- Despatch -> When I try to save an empty input, it doesn't show an error message.✅                                                                                                            
- Gst Percent & State -> The error message is showing with extra padding.✅
- Contact Type -> When I try to save an empty input, it doesn't show an error message.✅
- Payment Mode -> A dark gray scroll bar is showing below the table.


## Master
-  Contact List 
-            1. We need to write validation for contact_types.
-            2. The address is not being stored in the database. & also bank section.
-    Company 
-            1. In the Bank section, the bank input field's dropdown is not showing.
-    Style  
-            1. Currently, the image field is a text input — we need to change it to an image upload field.


## Books 
-    Account Heads
-            1. The error message is showing with extra padding. (in Name)✅
-    Ledger Group 
-            1. We need to write validation for Account Head.✅
-    Ledger -> 
-            1. I see two 'Ledger Name' input fields. The second one should be 'Ledger Group Name', not 'Ledger Name'. It's causing confusion.✅
-            2. We need to write validation for Ledger Name (2nd).✅
-            3. When I try to edit or update, the second 'Ledger Name' value , it only returns ID.✅
- ["The data type of all 'Current Balance' and 'Opening Balance' columns should be changed to integer.(we can also add validation)]✅


## // 16-04-2025 //

## Sales
[Contact Pop-up (PartyName)]
- We should write validation for contact_type.  ✅ fixed -no validation - set default value

[Style Pop-up (StyleName)]
- The image input is a text field right now. We need to change it to an image upload field. 

[E-way Bill Details (Tab)]
- We should write validation for Transport Name. ✅ fixed - no validation - set default value
- After I create a new transport, it shows an error (Cannot assign array to property) , but that transport successfully saved in the database.✅ fixed

//
- 'Back' button is not working.✅ fixed
- While editing, a random address is automatically filled in the address tab'.( 7th block, kuvempu layout, Chennai, Andhra Pradesh- 641601, -. )✅ fixed



## // 17-04-2025 //

## Purchase
- 1. We should write validation for Purchase No. ✅ fixed
- 2. We should write validation for Purchase date (or) set default date value.✅ fixed
- 3. While editing, a random address is automatically filled in the 'Address tab'. (3rd street, Postal Colony, Chennai, -- 641601, India. ) ✅ fixed
- 4. In the Product modal, when I press the Tab key to move between fields, it only works for the first three input fields. 

    
    

## // 29-04-2025 //  [Online]

- 1. When I create a new contact in 'Sales' or 'Purchase' entry, and then try to save the Sales or Purchase, it returns an error. (Column 'company_id' cannot be null)

## Books 
- 1. Account Heads -> When I try to delete an entry, the confirmation pop-up blended into the background.
- 2. Ledger Groups -> When I try to delete an entry, the confirmation pop-up  blended into the background.
- 3. Ledgers -> When I try to delete an entry, the confirmation pop-up  blended into the background.
             -> The error message text for the 'Ledger Group' input field is slightly larger than the normal error messages

## Receipt & Payment
- 1. When I create a new contact in 'Receipt' or 'Payment' entry, and then try to save the Receipt or Payment, it returns an error. (Column 'company_id' cannot be null)
- 2. When I edit a Payment or Receipt entry, the 'Voucher No' increases by 1. For example, if I enter 2, it changes to 3; if I enter 3, it changes to 4. 

## AccountBook
- 1. We should write validation for Transaction Type.
- 2. If the transaction type is set to 'Bank', validation needs to be written for 'Bank Name' and 'Account Type'.
- 3. If the transaction type is set to 'UPI', validation needs to be written for 'Bank Name' and 'Account Type'.
- 4. The 'Balance' is not displaying in the table, but it is stored in the database.
- 5. We should write validation for Party Name.

