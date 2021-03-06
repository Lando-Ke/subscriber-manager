# Subscription Manager

Subscription Manager {MailerLite}

### Rquirements

This App has been build using Laravel 9. View the full requirements list here
    
### Installation
```sh
gh repo clone Lando-Ke/subscriber-manager
$cd subscriber-manager
composer install
npm-install
create local database and update the .env file
$php artisan migrate
$php artisan db:seed
```

### Running it
To run it:
```sh
$npm run dev; php artisan serve
```
The app should now be available on http://localhost:8000 

### Running the tests
```sh
$composer test
```

### users
To view the front-end you will be required to create a user by going to
http://localhost:8000/register

### Front End (Laravel Breeze)
This app uses vue 3 for the front-end and has been built using the composition API
If you ran npm install during the setup process all the dependencies should be installed

After creating a user you will be redirected to /dashboard where you can view a list of subscribers, Add a subscriber, edit and delete them
Additional work is required to make field creation possible
![Screenshot 2022-04-25 at 08 25 05](https://user-images.githubusercontent.com/6400931/165026036-321fa1c6-af28-406e-b6c3-582b198bdc56.png)
![Screenshot 2022-04-25 at 08 25 26](https://user-images.githubusercontent.com/6400931/165026078-501db55a-984f-4716-a1ce-5a5eb2821983.png)
![Screenshot 2022-04-25 at 08 25 39](https://user-images.githubusercontent.com/6400931/165026097-4703aec5-6a86-4b2e-9b4f-3ce0bec524bf.png)
![Screenshot 2022-04-25 at 08 25 59](https://user-images.githubusercontent.com/6400931/165026118-f002932c-3459-40d2-a0e8-47f66e58ab12.png)


### API endpoints

#### Subscribers

**Get Subscriber**
----
  Returns the json result of a single subscriber.
* **URL**
  api/subscribers/{subscriber}
* **Method:**
  `GET`
*  **URL Params**
   **Required:**
   `id=[integer]`
* **Data Params**
  None
* **Success Response:**
  * **Code:** 200 <br />
    **Content:** <br />
    ```json
	"subscriber": {
		"id": 2,
		"name": "Bruce Wayne",
		"email_address": "bruce@ewayneenterprises.org",
		"state": "active",
		"state_id": 1,
		"fields": [
			{
				"id": 6,
				"title": "company",
				"value": "Wayne Enterprises"
			},
			{
				"id": 46,
				"title": "DOB",
				"value": "10-02-04"
			}
		],
		"created_at": "2022-04-24 12:18:21",
		"updated_at": "2022-04-24 12:20:07"
	},
	"status": "SUCCESS"
    ```
* **Error Response:**
  * **Code:** 404  <br />
    **Content:** <br /> `{
	"error": "Subscriber not found"
}`
* **Sample Call:**
  ```javascript
  const getSubscriber = async (id) => {
        let response = await axios.get(`/api/subscribers/${id}`);
        subscriber.value = response.data.subscriber
    };
  ```
  
**Get All Subscribers**
----
  Returns json result with all subscribers.
* **URL**
  api/subscribers/
* **Method:**
  `GET`
* **Data Params**
  None
* **Success Response:**
  * **Code:** 200 <br />
    **Content:** 
    ```json
    "subscribers": {
		"data": [
			{
				"id": 2,
				"name": "Samir Lando",
				"email_address": "luk38@example.net",
				"state": "active",
				"state_id": 1,
				"fields": [
					{
						"id": 4,
						"title": "sequi",
						"value": "vel"
					},
					{
						"id": 5,
						"title": "saepe",
						"value": "repudiandae"
					},
					{
						"id": 6,
						"title": "fugiat",
						"value": "ut"
					},
					{
						"id": 46,
						"title": "DOB",
						"value": "10-02-04"
					}
				],
				"created_at": "2022-04-24 12:18:21",
				"updated_at": "2022-04-24 12:20:07"
			},
			{
				"id": 3,
				"name": "Prof. Amya Harber",
				"email_address": "amelie.shanahan@example.com",
				"state": "unconfirmed",
				"state_id": 5,
				"fields": [
					{
						"id": 7,
						"title": "consectetur",
						"value": "repellat"
					},
					{
						"id": 8,
						"title": "illum",
						"value": "quidem"
					},
					{
						"id": 9,
						"title": "facilis",
						"value": "consequatur"
					}
				],
				"created_at": "2022-04-24 12:18:21",
				"updated_at": "2022-04-24 12:18:21"
			}
      ],
		"meta": {
			"current_page": 1,
			"last_page": 1,
			"per_page": 50,
			"total": 14,
			"path": "https:\/\/subscriber-manager.app\/api\/subscribers"
		},
		"links": {
			"first": "https:\/\/subscriber-manager.app\/api\/subscribers?page=1",
			"prev": null,
			"next": null,
			"last": "https:\/\/subscriber-manager.app\/api\/subscribers?page=1"
		}
	},
	"status": "SUCCESS"
    ```

* **Sample Call:**
  ```javascript
    const getSubscribers = async () => {
        let response = await axios.get('/api/subscribers');
        subscribers.value = response.data.subscribers.data
    };
  ```
  
**Edit Subscriber**
----
  Edit a single subscriber
* **URL**
  api/subscribers/{subscriber}
* **Method:**
  `PUT`
* **Sample Request**
   ```json
    
	{ "name" : "Clark Kent",
	  "email_address" : "clark@thedailyplanet.org",
	  "state_id" : 1 }

    ```
* **Success Response:**
  * **Code:** 200 <br />
   
* **Error Response:**
  * **Code:** 422 (Unprocessable Entity) <br />
    **Content:** 
    `{ "errors": " The name field is required. The email address field is required. The state id field is required."}`
* **Sample Call:**
  ```javascript
    try {
           await axios.patch(`/api/subscribers/${id}`, subscriber.value);
           await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                  errors.value += e.response.data.errors;
            }
        }
  ```
  
**Create Subscriber**
----
  Create a new subscriber
* **URL**
  api/subscribers/
* **Method:**
  `POST`
* **Sample Request**
  ```json
    {
	"name" : "Barry Allen",
	"email_address" : "allen@starlabs.org",
	"state_id" : 2 }
    ```
* **Success Response:**
  * **Code:** 201 <br />
    
* **Error Response:**
  * **Code:** 422 (Unprocessable Entity) <br />
    **Content:** `errors: { additional errors for every field },
        message: "The given data was invalid."`
* **Sample Call:**
  ```javascript
  
    try {
            await axios.post('/api/subscribers', data);
            await router.push({ name: 'subscribers.index' })
        } catch (e) {
            if (e.response.status === 422) {
                    errors.value += e.response.data.errors;
            }
        }
        
  ```
  
**Delete Subscriber**
----
  Delete the entry about the given subscriber
* **URL**
  api/subscribers/{subscriber}
* **Method:**
  `DELETE`
*  **URL Params**
   **Required:**
   `id=[integer]`
* **Data Params**
  None
* **Success Response:**
  * **Code:** 204

* **Sample Call:**
  ```javascript
    await axios.delete('/api/subscribers/' + id)
  ```
  
#### Fields
  
**Create Field**
----
  Create a ew field entry for user
* **URL**
  /api/subscriber/{susbcriber}/fields
* **Method:**
  `POST`
**Sample Request** 
```json
{
	"title" : "DOB",
	"type" : "date",
	"value" : "10-02-04"
}
```
* **Error Response:**
  * **Code:** 422 (Unprocessable Entity) <br />
    **Content:** `{
	"errors": " The title field is required. The type field is required. The value field is required."
}`
  
 
**Edit Field**
----
  Edit the entry for a given field
* **URL**
  api/subscriber/{subscriber}/fields/{field}
*  **URL Params**
   **Required:**
   `id=[integer]`
* **Method:**
  `PUT`
* **Sample Request**
  ```json
  {
	"title" : "height",
	"type" : "number",
	"value" : "5.11"}
  ```
  
    
### Todos
 - Add validation rule to ensure custom field is unique to subscriber
 - Add Field view to Front End
 - Add Pagination to Front End
 - Make it possible to create fields when creating subscriber
 - Autoload states to front end
 - Tests for the UI
