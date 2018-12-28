# Lumen API - Books database

## 1. Objective
The chalenge is to create a REST webservice to manage books, publishers and authors using at least a PHP Framework, where Lumen was choose, because it's a flexible, fast and have all good qualities from their framework parents: *Symfony* and *Laravel*.


## 2. Install
### 2.1. Docker
The development environment was built using Docker containers and managed by docker-compose.

To use this type of environment is necessary to install Docker ([https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)) and docker-compose ([https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)) on computer where this system will be tested.

**Just a remark**: If the host OS is Windows and already have Virtualbox installed and running, I sugest use the next proccess, because the last Windows Docker version use Hyper-V virtualization, incompatible with Virtualbox.

When Docker and docker-compose are installed, just go to the project root (same place where this README.md and [docker-compose.yaml](docker-compose.yaml) files are), so just type the command below:

```
docker-compose up
```

Before, if you are using a GNU/Linux OS is necessary change some Docker configurations inside the file [docker-compose.override.yaml](docker-compose.override.yaml):

***From***

```
UID: 1000
```

***To***

```
UID: [your local user UID]
```

And


***From***
```
user: 1000:1000
```

***To***

```
user: [your local user UID]:[your local group UID]
```

Where **[your local user UID]** and **[your local group UID]** are the UID of your current system user and group in host machine.

The docker-compose command will create two containers: web (with all necessary PHP and Apache stacks) and db (using MySQL). Tus, after some time, the containers will start showing the services on ports **80** and **3306**, so it's important don't have services using this ports before start this services.

Out of the box isn't necessary do changes on aplication configurations, but if it's the case, in the next topic maybe can clarify what need be changed.


### 2.2. Local environment already existent
To use this system in a already existent environment, just create a virtual host pointing to [public](site/public) folder, located inside *site* folder.

Create a database and change the [.env](site/.env), located inside the site folder, changing the connection details.


## 3. Start the application
After the application already hosted in local or server environment, is necessary run some console commands to change folders permitions, database structure and, if wished, seed with fake data.

To do this, all commands will be executed inside [public](site/public) folder, considering that the PHP is already installed and available to execute.

First, let's correct the permitions, executing the command (*Unix like systems), in other systems maybe isn't necessary:

```
chmod 755 vendor -R
```

Laravel is based on Symfony framework and uses composer to install important libraries inside to the project, so is necessary execute the command below:

```
php composer.phar install
```

After some time, if everything goes well, the *vendor* folder will be created with all necessary modules.

After, run the command below, to create all tables structure:

```
php artisan migrate
```


## 4. Available endpoints

The system already have methods to include, change, delete and get data, grouped by publishers, authors and books.

### 4.1. Group Publishers


* **List all data**

**Path:** publishers/list

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:**

```
{
    "header": {
        "status": "",
        "message": "",
        "total": 0
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **List records with offset and limit**

**Path:** publishers/list/{offset:integer}/{limit:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **Get one record by id**

**Path:** publishers/{id:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Insert a record

**Path:** publishers/{id:integer}

**Method:** post

**Return HTTP code:** 200

**Input body:**

```
    {
        "name": {string}
    }
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Update a record

**Path:** publishers/{id:integer}

**Method:** put

**Return HTTP code:** 201

**Input body:**

```
{
    "name": {string}
}
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Delete a record

**Path:** publishers/{id:integer}

**Method:** delete

**Return HTTP code:** 200

**Input body:** None

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": []
}
```


##### 4.2. Group Authors


* **List all data**

**Path:** authors/list

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "last_name": {string},
            "editorial_name": {string},
            "link": {string:url},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **List records with offset and limit**

**Path:** authors/list/{offset:integer}/{limit:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "last_name": {string},
            "editorial_name": {string},
            "link": {string:url},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **Get one record by id**

**Path:** authors/{id:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "last_name": {string},
            "editorial_name": {string},
            "link": {string:url},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Insert a record

**Path:** authors/{id:integer}

**Method:** post

**Return HTTP code:** 200

**Input body:**

```
    {
        "name": {string},
        "last_name": {string},
        "editorial_name": {string},
        "link": {string:url}
    }
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "last_name": {string},
            "editorial_name": {string},
            "link": {string:url},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Update a record

**Path:** authors/{id:integer}

**Method:** put

**Return HTTP code:** 201

**Input body:**

```
{
    "name": {string},
    "last_name": {string},
    "editorial_name": {string},
    "link": {string:url}
}
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "id": {integer},
            "name": {string},
            "last_name": {string},
            "editorial_name": {string},
            "link": {string:url},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Delete a record

**Path:** publishers/{id:integer}

**Method:** delete

**Return HTTP code:** 200

**Input body:** None

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": []
}
```



##### 4.2. Group Books


* **List highlighted books**

**Path:** books/highlighted 

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **List highlighted books with offset and limit**

**Path:** books/highlighted/{offset:integer}/{limit:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **List records by keyword**

**Path:** books/search/{term:string}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **List records by keyword, offset and limit**

**Path:** books/search/{term:string}/{offset:integer}/{limit:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:** 

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        },
        ...
    ]
}
```


* **Get one record by id**

**Path:** authors/{id:integer}

**Method:** get

**Input body:** None

**Return HTTP code:** 200

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Insert a record

**Path:** books/{id:integer}

**Method:** post

**Return HTTP code:** 200

**Input body:**

```
{
    "title": {string},
    "publisher_id": 2,
    "publish_date": {date},
    "isbn": {integer:10},
    "isbn_thirteen": {insteger:13},
    "description": {string},
    "image": {string:url},
    "highlight": {boolean:1|0},
    "deleted_at": null,
    "created_at": {datetime},
    "updated_at": {datetime},
    "authors": [{integer:Author},{integer:Author},...]
}
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Update a record

**Path:** books/{id:integer}

**Method:** put

**Return HTTP code:** 201

**Input body:**

```
{
    "title": {string},
    "publisher_id": {integer:Publisher},
    "publish_date": {date},
    "isbn": {integer:10},
    "isbn_thirteen": {insteger:13},
    "description": {string},
    "image": {string:url},
    "highlight": {boolean:1|0},
    "deleted_at": null,
    "created_at": {datetime},
    "updated_at": {datetime},
    "authors": [{integer},{integer},...]
}
```

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": [
        {
            "title": {string},
            "publisher_id": {integer:Publisher},
            "publish_date": {date},
            "isbn": {integer:10},
            "isbn_thirteen": {insteger:13},
            "description": {string},
            "image": {string:url},
            "highlight": {boolean:1|0},
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime},
            "authors": [
                {
                    "id": {integer:Author},
                    "editorial_name": {string}
                },
                ...
            ]
            "deleted_at": null,
            "created_at": {datetime},
            "updated_at": {datetime}
        }
    ]
}
```


* Delete a record

**Path:** books/{id:integer}

**Method:** delete

**Return HTTP code:** 200

**Input body:** None

**Result:**

```
{
    "header": {
        "status": {string},
        "message": {string},
        "total": {integer}
    },
    "content": []
}
```


## 5. Inserting data

It's possible insert data using the specifics endpoints url using POST HTTP method or simply using an automatic database seeder, with fake data.

To seed the database, inside the folder [site](site), run the command:

```
php artisan db:seed
```


## 6. Unity tests

This system was built using TDD methodology with PHPUnit framework.

So, it's possible to see the tests results executing the command below in [site](site) folder:

```
vendor/bin/phpunit
```


#### 7. System stack

The stack used is, basically, a LAMP:

* PHP (Version 7.1.x);

* Apache or NGINX (latest version possible);

* MySQL database (5.6 or higher);

* Lumen framework (Version 5.7).

More details about Apache configurations, PHP modules and others, can be found in files: [docker-compose.yaml](docker-compose.yaml), [docker-compose-override.yaml](docker-compose-override.yaml) and [configs/Dockerfile](configs/Dockerfile).
