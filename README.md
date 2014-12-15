# Internet of Things Aggregation (IoTA) Feed Specifications
* Version 0.10.0
* Authored by Robert Gerald Porter 
* Copyright 2011-2014 Weever Apps Inc

IoTA is a standard for delivering any kind of content via JSON or JSON-P. It is designed to be semantic and scalable, whilst being specific enough to have minimum standards that all feeds adhere to.

Initially designed as a replacement for RSS technologies to feed content to mobile devices, IoTA has grown into a technique for retrieving content from known sources in a consistent fashion, almost as if it were a distributed database. We have implemented plugins for WordPress and Joomla for retrieving web content in IoTA form, and are now writing tools to retrieve content data direct from database systems such as CouchDB in a standard format.

It is our aim to continue to adjust the specifications towards the goal of being able to aggregate any data onto any device or platform.

## JSON Schema

All feeds are in JSON or JSON-P format. 

There are three tiers of properties; feed properties, object properties, and detail properties.

### Feed Properties
Feed properties are generic properties used as "metadata" about the feed itself. 

    {
        "localization": "en-CA",
        "copyright":    "2011-2014 IoTA Widgets Inc.",
        "license":      "Creative Commons Attribution 4.0 International",
        "generator":    "My fancy IoTA Generator",
        "author":       "Jane Doe",
        "publisher":    "IoTA Publishers Inc.",
        "rating":       "All ages",
        "iotaVersion":  "0.10.0",
        "url":          "http://example.com/url-to-this-feed.json",
        "items":        []
    }
    
`localization` refers to the ISO 639-1 Standard for localization codes: <http://en.wikipedia.org/wiki/Language_localisation> 
`copyright` is used to declare copyright on the feed content
`license` is used to indicate a particular content usage license
`generator` is used to indicate the agent generating the feed
`author` is used to indicate the author of the content
`publisher` is used to indicate the service publishing the feed
`rating` is used to indicate a content rating for age-appropriateness
`iotaVersion` is used to indicate the version of IoTA standard being used
`url` indicates the url that the feed was called from
`items` contains any child content objects

### Object Properties
Object properties are properties that describe the content in *summary*. "Feed Properties" may also be mixed in when not contained within an `items` array.

At minimum it contains enough data to give the intended audience enough information to be able to decide if they wish to request all data about an object. 

Generally the detailed content is linked to via the `url` parameter, though it can also contain all the data available with in the `details` property instead.

    {
        "name":             "My object",
        "uuid":             "655156f0-6b51-11e4-9803-0800200c9a66",
        "version":          "68138367e67ec45f55d1d624f639baf0",
        "type":             "html",
        "geo":              [
            {
                "address":      "123 Fake Street, Hamilton, Ontario, Canada",
                "latitude":     "45.00",
                "longitude":    "65.00",
                "altitude":     "0"
            }
        ],
        "url":              "http://example.com/url-to-the-details-object.json",
        "description":      "A brief summary of the object",
        "images":           ["http://placehold.it/250x150"],
        "tags":             ["example content", "IoTA"],
        "datetime":         {
                "published":    "January 11, 2012"
            },
        "actions":          {
                "delete":   "http://example.com/api/url_to_delete_object_if_authorized"
            },
        "relationships":    [
            {
                "references":   "http://example.com/url-to-iota-feed-with-references.json"
            }
        ],
        "details":          {}
    }
The `type` values that are valid are listed below under "Valid Types". 

The `geo` property is for georeferencing an object; perhaps a building location or locations, or a KML polygon shape. 

The `actions` property is provided to give API URL endpoints for actions that can be taken by the user who sees the feed (do not display actions the user cannot currently take). 

The `relationships` property is provided in order to provide custom references to other related content. This can be varied depending on the source. It is intended to add semanticity to the feed. 

The `details` property, if used, would contain within the "Detail Properties" listed below.

### Detail Properties
Detail properties contain detailed information about an object. This is intended to be the lowest level of the tiers. "Object properties" may also be mixed in with these when not contained within a `details` property. 

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
        	"style":    "/*CSS DECLARATIONS COULD GO HERE*/"
        },
        "properties":   {}
    }
If this JSON was provided in a standalone feed, it would be mixed with properties in the Object Properties section. Otherwise, these properties would be within the `details` property.

The `html` property is designed to contain pure HTML content.

The `assets` property should contain any assets *required* to view the HTML content. If some content is optional and is referenced in the HTML, do no list it here. In the case where no `html` value is specified -- for example, when referencing pure media such as video, audio, or image files, assets should be sorted in the order they are intended to be consumed.

The `properties` object is intended to be a catch-all for more complex objects being described with variables. For example, a real estate property being described as an object in a feed would contain specific properties such as `listPrice`, `rooms`, `acreage`, etc. These can be left *schemaless* if the intention is for a developer to handle any property that is given; however, if you wish to specify a schema in order to enforce consistency, see the Custom Type Schema specifications below.

### Other Notes
Any property prefixed with underscore `_` should be ignored by IoTA parsers, and considered a "comment", or developer documentation. JSON does not allow for inline comments, so this is our compromise.

Any property prefixed with a double underscore `__` should also be ignored, and should be reserved for content generated automatically by a feed provider for internal purposes. For example, a timestamp, server signature, etc. An example of this usage would be:

    {
        "__timestamp":      "2014-11-13T14:19:09-05:00",
        "__server":         "iota-feed-001",
        "name":             "Test",
        "tags":             ["testing", "comments"],
        "properties":       {
            "test":     true,
            "_test":    "If true, this is a test, if false this is real."
        }
    }

### Valid Types


* `channel` contains sub-objects listed under an array of `items`
* `html` contains purely HTML content
* `media` contains multimedia content which may be under the `html` (embed codes) or `assets` array 
* `event` contains content that has specific times required, generally under the properties `datetime.start` and `datetime.end`
* `profile` contains content that describes a physical object or person
* `tableData` contains pure data, generally only using the `properties` property in details
* `inputRequest` contains form information, which could be used to prompt for user responses, and should only contain `properties`
* `schema` contains architectural information used to describe a custom IoTA type

#### Deprecated Types

* `htmlContent` see `html`
* `events` see `event`
* `profiles` see `profile` 


### Custom IoTA Schema

If you wish to enforce or provide a predictable schema for a category of objects, you can specify the `type` as a JSON object, like this:
    
    {
        "name":         "ourMeatCompany/meatCut",
        "version":      "0.2.0",
        "schemaUrl":    "http://mysite.com/meat_cut_spec.json"
    }

The IoTA Schema file is itself a valid IoTA feed, with all expected properties inside the `properties` value listed out with `properties.versions["X.y.z"]`, in addition to any notes or comments you might wish others using the feed to read.

Note that multiple versions of a schema can be kept within a single file. While these "versions" could instead be any kind of label, it is suggested to follow Semantic Versioning <http://semver.org/>.

	{
        "name": "ourMeatCompany/meatCut",
        "description": "Standard feed for a packaged cut of meat.",
        "iotaVersion": "0.10.0",
        "author": "Robert Gerald Porter",
        "copyright": "2014, Weever Apps Inc",
        "url": "http://mysite.com/meat_cut_spec.json",
        "type": "schema",
        "version": "0.2.0",
        "properties": {
            "documentationUrl": "http://mysite.com/meat-cut-spec-docs",
            "validatorUrl": "http://mysite.com/validator/",
            "currentStableVersion": "0.2.0",
            "versions": {
                "0.1.0": {
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
    
Anything outside of the `properties` value of this feed is basically metadata, only the `name` value is required in order to validate the schema is the correct one.

Within `properties`, the only required property is `versions`. Other fields are optional:

* `documentationUrl` (optional) is to provide a website URL to more detailed documentation for the use of the schema.
* `validatorUrl` (optional) is an URL to a validation service for your IoTA feed using this schema.
* `currentStableVersion` (optional) should give a new developer a hint as-to which version to choose. Normally this is the highest version, but you may have an experimental schema for testing only you may want users to avoid.
* `versions` (required) an object with version-number labels containing the properties expected within a object's `properties`. Alternatively, this can be a string with an URL to another IoTA Schema Feed with all the expected properties directly inside `properties`. Anything prefixed with `_` is understood to be a comment, and can be used for inline documentation of the properties.