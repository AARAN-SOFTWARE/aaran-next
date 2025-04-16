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
- When I try to create a new contact in 'Party Name' field it shows this error - 'Cannot assign array to property' , but the contact is still saved successfully in the database. 
- After saving contact, it doesn't return to the sale's upsert page.
- We should write validation for contact_type in the Contact. 
- In the contact's address section, even after we type the address, area, city, and state, etc ..  the error messages still stay and don’t go away.
- If a similar contact already exists in the database, the 'Create New Contact' button doesn’t appear when trying to add a new one.
    - for example - If I already have a contact named 'Sundarapandiyan' in the database, and I try to create a contact named 'Sundar', the 'Create New Contact' button doesn’t show.It only suggests 'Sundarapandiyan'.
    - similar names like 'Rajesh' and 'Raj'.
    - this same happens to Product Modal.
  
[Product Pop-up (ProductName)]
- When I try to create a new product in 'Product Name' field it shows this error - 'Undefined array key "gst_percent"' , but the product is still saved successfully in the database. 
- After saving product, it doesn't return to the sale's upsert page.


- We should write validation for Transport.
- 'Back' button is not working.
- After Save it doesn't redirect to Sale's Index Page.
- after working these,  we should check 'Address' Tab. (it also have some issues)
