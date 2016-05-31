# Internet of Things Aggregation (IoTA) Feed Specifications
* Version 0.14.0 
* Authored by Robert Gerald Porter & Matt Grande
* Copyright 2011-2016 Weever Apps Inc

IoTA is a standard for delivering any kind of content via JSON or JSON-P. It is designed to be semantic and scalable, whilst being specific enough to have minimum requirements that all implementations adhere to.

Initially designed as a replacement for RSS technologies to feed content to mobile devices, IoTA has grown into a technique for retrieving content from known sources in a consistent fashion. Example implementations have included plugins for CMS systems such as Joomla and WordPress, API interfaces with NoSQL solutions such as CouchDB, and standard feed formats for data aggregating to and from Internet-of-Things (IoT) devices.

It is the aim to continue to develop the specifications towards a goal of being able to aggregate any data onto any device or platform.

## JSON Schema

All feeds are in JSON format. Compatible formats such as JSON-P are also acceptible.

There are two tiers of properties: **feed properties**, and **object properties**.

### Feed properties
Feed properties are generic properties used as "metadata" about the feed itself. 

    {
        "iotaVersion":  "0.14.0",
        "type":         "collection",
        "localization": "en-CA",
        "copyright":    "2011-2015 IoTA Widgets Inc.",
        "license":      "Creative Commons Attribution 4.0 International",
        "generator":    "My fancy IoTA Feed Generator",
        "authors":      ["Jane Doe", "John Smith"],
        "publisher":    "IoTA Publishers Inc.",
        "url":          "http://example.com/url-to-this-feed.json",
        "items":        []
    }

| _Property_   	| _Required?_ 	| _Description_ |
|:-------------	|:------------:	|:--------------------------------------|
|  `iotaVersion`  | **Yes** | Indicates the IoTA Specification version. |
|  `type` | **Yes**	| Indicates either the Standard Type or Custom Type that this object belongs to. |
| `localization`| No | Refers to the [ISO 639-1](http://en.wikipedia.org/wiki/Language_localisation) Standard for localization codes, generally two letters for language, two for region, e.g. "en-US" for U.S. English.  |
| `copyright` | No  | Used to declare copyright on the feed content.  |
| `url`| No  | indicates the url that the feed was called from.  |
| `license`	| No | Used to indicate a particular content usage license. |
| `generator`| No | Used to indicate the agent generating the feed. |
| `authors`| No | Used to indicate the author(s) of the content. |
| `publisher`| No | Used to indicate the service publishing the feed|
| `items`| No | Contains any child content objects, used specifically by the IoTA Standard Type `collection`.|


### Object properties
Object properties are properties that describe the content in *summary*. "Feed Properties" should also be mixed in when not contained within an `items` array.

At minimum, an object contains enough data to give the intended audience enough information to be able to decide if they wish to request all data about an object. 

If more detailed data exists, that content is linked to via the `url` parameter. Alternatively, all existing data can be contained within the object's `details` property.

    {
    	"name": "My object",
    	"type": "html",
    	"iotaVersion": "0.14.0",
    	"uuid": "655156f0-6b51-11e4-9803-0800200c9a66",
    	"revision": "68138367e67ec45f55d1d624f639baf0",
    	"authors": ["Jane Doe", "Jon Smith"],
    	"url": "http://example.com/url-to-the-details-object.json",
    	"description": "A brief summary of the object",
    	"images": ["http://placehold.it/250x150"],
    	"geo": [{
    		"address": "123 Fake Street, Hamilton, Ontario, Canada",
    		"latitude": "45.00",
    		"longitude": "65.00",
    		"altitude": "0"
    	}],
    	"taxonomies": {

    		"tags": ["objects", "examples"],
    		"categories": ["things"],
    		"genres": ["fiction"]
    	},
    	"status": ["draft"],
    	"datetime": {

    		"published": 1454686890,
    		"created": 1454695972,
    		"updated": 1454712871
    	},
    	"relationships": [{
    		"references": "http://example.com/url-to-iota-feed-with-references.json"
    	}],
    	"actions": {
    		"delete": "http://example.com/api/url_to_delete_object_if_authorized"
    	},
    	"details": {}
    }
    

| _Property_   	| _Required?_ 	| _Description_ |
|:-------------	|:------------:	|:--------------------------------------|
|  `name`      	| **Yes**    	| Indicates the human-readable name of the object. |
|  `type`      	| **Yes**		| Indicates either the Standard Type or Custom Type that this object belongs to.|
| `iotaVersion` | **Yes**			| An indicator for the version of IoTA you are using |
| `uuid`  		| **Yes** 		| A universally unique identifier for the object.   |
| `revision`  	| No  			| Used to indicate a unique version of the object.  |
| `authors`     | No           | Used to indicate the author(s) of the content. |
| `url`  		| No  			| Used to point to either the source of the current object feed, or a source which contains more details about the object.  |
| `description`	| No 			| A human-readable summary about the object. |
| `status`		| No			| An array of the status(es) of the content. |
| `images`		| No 			| An array of URLs to relevant images.|
| `geo`			| No 			| Used to geo-reference an object. This can be an array of objects referencing GPS coordinates, addresses, polygon shapes, etc. |
| `taxonomies`	| No 			| Used to attach taxonomical and semantic data, such as tags, genres, categories, and other taxa.|
| `relationships`|				| Used to refer to related content such as parent/child/sibling objects and citations. |
| `actions` 	| No 			| Used to indicate API URL endpoints where actions can be taken by the user. Only actions that the user is capable of taking should be indicated.|
| `details`  	| No 			| Used to provide the full content of the object rather than having the user request further data. Contains data as indicated within the "Detail Properties" listed below.|
  
##### _Deprecation Notes_

_`tags` is deprecated, replaced by `taxonomies`. Please add tags as an individual taxonomy._

`properties` and `html` were previously accepted outside the scope of `details` within an object, this is no longer the case. These properties should always remain within a `details` property.

### Detail-Properties
Detail-properties contain detailed information about an object. This is intended to be the lowest level of the tiers, and is optional when retrieving summary data, such as in feeds.

    {
        "html":         "<h1>Here be our HTML Content</h1><p>Here's the content text. The HTML and BODY tags are not assumed tobe part of this content.</p><p>Here's an image: <img src=\"http://placehold.it/250x150\"></p>",
        "assets":       [
            {
                "url":          "http://placehold.it/250x150",
                "mimeType":     "image/gif"
            }
        ],
        "css":			{
        	"url":      "http://example.com/mycss.css",
        	"style":    "p.example { display: none; }"
        },
        "properties":   {}
    }
    
| _Property_   	| _Description_ |
|:-------------	|:--------------------------------------|
|  `html`      	| A string containing purely HTML-formatted content. |
|  `assets` | Digital assets such as images, video, audio, or multimedia content. Also, when used in concert with the `html` property, `assets` should contain references to any assets that are *required* to render the HTML so that offline systems can pre-cache media. Each asset should have a `mimeType` and `url`. |
| `css`| Any CSS content required to compliment the `html` content. Accepted properties include `url` (an URL to a CSS stylesheet), and `style` (a string of CSS declarations). |
| `properties`| A catch-all object space for more complex objects as described below under "Custom Types". This object may also be schemaless, should the `data` type be chosen. |


### Access and Administrative Control

Though it would never be displayed as part of an aggregated feed unless requested by an administrative user, access control can be handled through an `accessControls` property. 

This is how it might be stored in a database system:

    "accessControls":	{
        "users": {
            "john": { 
            	"read": true, 
            	"write": true
            },
            "fred": { 
            	"read": false
            }
        },
        "roles": {
            "staff": { 
            	"read": true, 
            	"write": false 
            },
            "admin": { 
            	"read": true, 
            	"write": true
            }
        }
    }
    
At the deepest level, an array where each element is either a string or an object is provided. If it is a `string`, the permission is presumed to be allowed, however an object can explicitly say if the permission is allowed or denied.

In the above example, all staff members would have `read` access, except Fred, as he is explicitly denied access.
    
A system delivering IoTA feeds should never expose this property without proper authentication, and should only accept it when incoming from an autenticated source.

### Comments, Logging, and Reserved Keys
Any property prefixed with underscore `_` should be ignored by IoTA parsers, and considered a "comment", or developer documentation. JSON does not allow for inline comments, so this is our compromise.

Any property prefixed with a double underscore `__` should also be ignored, and should be reserved for content generated automatically by a feed provider for logging or other internal purposes. For example, a timestamp, server signature, etc. 

Any property key prefixed with an 'at' symbol `@` is a reserved key, for specific functional use in IoTA parsing. An example would be mapping the schema-defined values of a stash to a root IoTA property.

    {
        "__timestamp":      "2015-04-13T14:16:19-05:00",
        "__server":         "iota-feed-aggregator-001",
        "name":             "Test",
        "properties":       {
            "test":     true,
            "_test":    "If true, this is a test, if false this is real."
        }
    }

### Standard Types

Standard types are the only valid IoTA types where a schema is globally standardized, as opposed to custom schemas which are domain-specific.

| Type | Description |
|:---------|:---------------------------------------------------------------------------------------------------|
| `collection` | A collection of sub-objects contained within property `items` |
| `html` | Standard HTML content |
| `media` | Media content, such as images, video, audio, or multimedia. |
| `event` | Content with a limited time range, such as an appointment, due date, or gathering. |
| `profile` | Content that describes an object, person, or group. |
| `data` | Schema-less data, with all content generally found within `properties`. |
| `schema` | Denotes architectural information used to describe a custom IoTA type instead of a standard type. |

#### Deprecated Types

| Deprecated Type | Replaced by |
|:---------|:---------------------------------------------------------------------------------------------------|
| `channel` | `collection` |
| `htmlContent` | `html` |
| `events` | `event`|
| `profiles` | `profile` |
| `tableData` | `data` |
| `inputRequest` | No direct replacement - use Custom Types instead. |

### Custom Types

Custom Types exist to allow great flexibility in the IoTA standard. The six Standard Types (ignoring `schema` type) have been selected and designed for their universality, and while useful for most contexts, are not useful for all. In circumstances where adherance to a custom schema is required, the standard types are not sufficient. 

If you wish to enforce or provide a predictable schema for a category of objects, you can specify the `type` as a JSON object, like this:
    
    {
        "name":         "ourMeatCompany/meatCut",
        "version":      "0.2.0",
        "schemaUrl":    "http://mysite.com/meat_cut_spec.json"
    }
    
The Custom Type `name` property follows a *domain pattern* whereby a domain (such as a company name) is used to namespace a Custom Type. This can be done at several levels if desired, such as `aCompanyName/internalNamespace/anObject`.

The IoTA Schema JSON feed is itself a valid IoTA feed, with all expected properties inside the `properties` value listed out with `properties.versions["X.y.z"]`, in addition to any notes or comments you might wish others using the feed to read.

Multiple versions of a schema can be kept within a single file. While these "versions" could instead be any kind of label, it is suggested to follow Semantic Versioning as described on [SemVer.org](http://semver.org/).

	{
        "name": "ourMeatCompany/meatCut",
        "description": "Standard feed for a packaged cut of meat.",
        "iotaVersion": "0.14.0",
        "authors": ["Robert Gerald Porter"],
        "copyright": "2014, Weever Apps Inc",
        "url": "http://mysite.com/meat_cut_spec.json",
        "type": "schema",
        "revision": "abcd1234",
        "details": {
            "properties": {
                "documentationUrl": "http://mysite.com/meat-cut-spec-docs",
                "validatorUrl": "http://mysite.com/validator/",
                "currentReleaseVersion": "0.2.0",
                "versions": {
                    "0.1.0": {
                        "@map": {
                       		"name": "product"
                        },
                        "_notes": {
                            "_version_notes": "Initial schema version",
                            "product": "Meat Product",
                            "config": "Product package configuration",
                            "weight": "Weight in kg",
                            "region": "Name of the county the source farm is in.",
                            "ration": "Rations that were fed to animal.",
                            "tenderness": "Score between 0 and 10."
                        },
                        "id": 0,
                        "code": 0,
                        "product": "",
                        "config": "",
                        "weight": 0,
                        "date": "YYYY-MM-DD",
                        "region": "",
                        "ration": "",
                        "tenderness": 0
                    },
                    "0.2.0": {
                        "_notes": {
                            "_version_notes": "Improvements made to structure of properties.",
                            "product": {
                                "name": "Name of the cut",
                                "tenderness": "Rating from 0 through 10.",
                                "package": {
                                    "config": "The packaging format.",
                                    "date": "Date of packaging",
                                    "weight": "Weight of package in kilograms"
                                }
                            },
                            "farm": {
                                "region": "Region of the farm",
                                "ration": "List of rations being fed to the animal",
                                "address": "Street address of the farm"
                            }
                        },
                        "@map": {
                        	"name": {
                        		"product": {
                        			"name": ""
                        		}
                        	}
                        },
                        "id": 0,
                        "code": 0,
                        "product": {
                            "name": "",
                            "tenderness": 0,
                            "package": {
                                "config": "",
                                "date": "YYYY-MM-DD",
                                "weight": 0
                            }
                        },
                        "farm": {
                            "region": "",
                            "ration": "",
                            "address": ""
                        }
                    }
                }
            }
        },
        "__success": true,
        "__server_version": "3.5.193",
        "__call": {
            "url": "http://mysite.com/meat_cut_spec.json",
            "server": "mysite.com",
            "endpoint": "/meat_cut_spec.json",
            "query": {
                "type": "get",
                "params": {}
            },
            "execution_time": "0.111s"
        }
    }
    
The `name` property is required in order to validate the schema is the correct one. 

Within `properties`, the only required property is `versions`. Other fields are optional:

* `documentationUrl` (optional) is to provide a website URL to more detailed documentation for the use of the schema.
* `validatorUrl` (optional) is an URL to a validation service for your IoTA feed using this schema. Note that validators do not currently have a standard API so you will need to consult any API documentation available.
* `currentReleaseVersion` (optional) should give a new developer a hint as-to which version to choose. Normally this is the highest version, but you may have an experimental schema for testing only you may want users to avoid.
* `versions` (required) an object with version-number labels containing the properties expected within a object's `properties`. Alternatively, this can be a string with an URL to another IoTA Schema Feed with all the expected properties directly inside `properties`. Anything prefixed with `_` is understood to be a comment, and can be used for inline documentation of the properties.