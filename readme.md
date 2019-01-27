# Suchadummy CMS

Suchadummy CMS is a simple flat file CMS library that you
can use with your framework of choice

## What can you do

* Write and edit your content in flat files using
Markdown or a custom markup language
* Integrate your content with your framework of choice
* Get your content automatically converted to HTML
* Write publications and categories
* Use this library for a portion of your content, not all of it
* Add metadata and custom fields
* Add global variables
* Customize the metadata format
* Customize the content format
* Customize the variables format
* Use folders to organize your content

## What it is not

* A full fledged CMS
* A site generator (but you can use it in that way)

## For what should I use it?

* A simple blog
* To write documentation
* To manage simple content

## Usage example

Let's say that you want to write news feed for the homepage of your
website.

1. Write your content in markdown files
2. Use Suchadummy to parse your content
3. Save the content of your publications to a variable
4. Display them wherever you want in your website

### /news

#### /news/wishlist.md
```
{
    "contentType": "publication",
    "id": "2018-wishlist",
    "date": "2018-01-01"
}
========================
# This is our wishlist for **2018**

* Be better
* Get to 2019 alive
```

#### /news/new-website.md
```
{
    "contentType": "publication",
    "id": "new-website",
    "date": "2018-02-01"
}
========================
Hey! Checkout our new website [Google](https://google.com)
```

#### PHP

##### Use the facade to create a CMS

```php
$cms = SuchadummyFacade::buildCms(
    '/var/www/content/', // Location of the content files
    [
        'baseUrl' => $_ENV['BASE_URL'] . '/projects/collection',
    ], // Global variables
    new DefaultBuilder // CMS builder, use the DefaultBuilder or create a custom one
);
```

##### Get your content

```php
$cms->getAllPublications();
// Publication[]

$cms->getPublicationById('home');
// Publication

$cms->getAllCategories();
// Category[]

$cms->getCategoryById('mycat');
// Category
```

##### And display it

```php

$cms->getAllPublications()->each(function (Publication $publication) {

    echo "<h1>{$publication->getTitle()}<h1>";
    echo $publication->getContent();

});

```

## Publications and Categories

### Publications

* A *publication* has content and categories (optional)

Required metadata
* id
* contentType

Optional metadata
* excerpt
* date
* customFields
* author
* slug
* categories

### Categories

* A *category* has a title and content (optional)

Required metadata
* id
* contentType
* title

Optional metadata
* excerpt
* date
* customFields
* author
* slug


## Structure of a file

A content file should have one of these structures:

1. **metadata + fence**
2. **metadata + fence** + content

### Custom fields

You can add custom fields to your publications and categories
by using the metadata *customFields*

```
{
    "contentType": "category",
    "id": "new-website",
    "title": "mycat"
    "customFields": {
        "language": "en"
    }
}
========================
```

### Global variables

#### Set them while creating your CMS

```php
$cms = SuchadummyFacade::buildCms(
    '/var/www/content/', // Location of the content files
    [
        'baseUrl' => $_ENV['BASE_URL'] . '/projects/collection',
    ], // Global variables
    new DefaultBuilder // CMS builder, use the DefaultBuilder or create a custom one
);
```

#### And use them in your content

```
{
    "contentType": "publication",
    "id": "new-website",
    "date": "2018-02-01"
}
========================
Hey! Checkout our new [website]({{ baseUrl }})
```

### Advanced customization

This package is highly customizable and the docs are coming soon.
Feel free to browse the code to access these features.
