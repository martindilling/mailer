# Contact page

Simple contact page that works on both desktop and mobile.
I have written some colors and measurements on the `*-Info.png` files. They're not meant as rules but more a guideline, just to avoid measuring and colorpicking on the images :)
It should send an ajax POST request to `http://mailer.martindilling.com/send` in the format:

````
{
    "name":"Some name",
    "email":"mail@example.com",
    "message":"Some message"
}
````

The responses will be either `200 OK` on success:
````
{
    "status": "The mail was send"
}
````

or a `422 Unprocessable Entry` if there are validation errors:
````
{
    "status": "Validation failed",
    "errors": {
        "name": [
            "Name is required.",
            "Name must be between 3 and 30 characters."
        ],
        "email": [
            "Email is required.",
            "Email must be valid."
        ],
        "message": [
            "Name is required.",
            "Message must be between 50 and 2000 characters."
        ]
    }
}
````
**Doesn't send any mails, just simulates an api :)*

