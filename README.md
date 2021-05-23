# CARENDAR API DOC

> Saloon

|Type           | URI              | Auth           | 
| ------------- | ---------------- |:--------------:| 
|GET            | saloon/{id_auth} | Token          | 
|GET            | saloon           | Token          |
|POST           | saloon           | Token          | 
|PUT            | saloon           | Token          | 


> Customers

|Type           | URI               | Auth           | 
| ------------- | ----------------- |:--------------:| 
|GET            | customer          | Token          | 
|GET            | customer/{cus_id} | Token          |
|POST           | customer          | Token          | 
|PUT            | customer/{cus_id} | Token          | 
|DELETE         | customer/{cus_id} | Token          | 

> Appointments

|Type           | URI                           | Auth           | 
| ------------- | ----------------------------- |:--------------:| 
|GET            | appointment/saloon            | Token          | 
|GET            | appointment/date              | Token          |
|GET            | appointment/customer/{cus_id} | Token          | 
|GET            | appointment/cash              | Token          | 
|POST           | appointment                   | Token          | 
|PUT            | appointment/{app_id}          | Token          | 
|PUT            | appointmentState/{app_id}     | Token          | 
|DELETE         | appointment/{app_id}          | Token          | 

> Services

|Type           | URI               | Auth           | 
| ------------- | ----------------- |:--------------:| 
|GET            | services          | Token          | 
|GET            | services/{app_id} | Token          |
|POST           | services          | Token          | 
|PUT            | services/{ser_id} | Token          | 
|DELETE         | services/{ser_id} | Token          | 

> Stock

|Type           | URI               | Auth           | 
| ------------- | ----------------- |:--------------:| 
|GET            | stock             | Token          | 
|POST           | stock             | Token          |
|PUT            | stock/{sto_id}    | Token          | 
|DELETE         | stock/{sto_id}    | Token          | 

> Language

|Type           | URI                   | Auth           | 
| ------------- | --------------------- |:--------------:| 
|GET            | language          | Token          | 
|GET            | language/{sal_id}    | Token          |
|POST           | language          | Token          | 
|PUT            | language          | Token          | 
|DELETE         | language/{sal_id} | Token          | 

> Cash

|Type           | URI                   | Auth           | 
| ------------- | --------------------- |:--------------:| 
|GET            | cashregister          | Token          | 
|GET            | cashregisterClosed    | Token          |
|POST           | cashregister          | Token          | 
|PUT            | cashregister          | Token          | 
|DELETE         | cashregister/{sal_id} | Token          | 

> Tours

|Type           | URI                   | Auth           | 
| ------------- | --------------------- |:--------------:| 
|GET            | tours          | Token          | 
|POST            | tours    | Token          |
|PUT           | tours          | Token          | 
|DELETE            | tours          | Token          | 

> Statistics

|Type           | URI                   | Auth           | 
| ------------- | --------------------- |:--------------:| 
|GET            | statistics          | Token          | 

> Transaction

|Type           | URI                   | Auth           | 
| ------------- | --------------------- |:--------------:| 
|GET            | transaction           | Token          | 
|POST           | transaction           | Token          |
|PUT            | transaction/{tra_id}  | Token          | 
|DELETE         | transaction/{tra_id}  | Token          | 






















