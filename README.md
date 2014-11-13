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
        "language":     "en-US",
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

Content objects would be included inside `items`.

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
        "properties":   {}
    }
If this JSON was provided in a standalone feed, it would be mixed with properties in the Object Properties section. Otherwise, these properties would be within the `details` property.

The `html` property is designed to contain pure HTML content.

The `assets` property should contain any assets *required* to view the HTML content. If some content is optional and is referenced in the HTML, do no list it here. In the case where no `html` value is specified -- for example, when referencing pure media such as video, audio, or image files, assets should be sorted in the order they are intended to be consumed.

The `properties` object is intended to be a catch-all for more complex objects being described with variables. For example, a real estate property being described as an object in a feed would contain specific properties such as `listPrice`, `rooms`, `acreage`, etc. These can be left *schemaless* if the intention is for a developer to handle any property that is given; however, if you wish to specify a schema in order to enforce consistency, see the Custom Type Schema specifications below.

### Valid Types


* `channel` contains sub-objects listed under an array of `items`
* `html` (*or deprecated `htmlContent`*) contains purely HTML content
* `media` contains multimedia content which may be under the `html` (embed codes) or `assets` array 
* `event` (*or deprecated `events`*) contains content that has specific times required, generally under the properties `datetime.start` and `datetime.end`
* `profile` (*or deprecated `profiles`*)
* `tableData` contains pure data, generally only using the `properties` property in details
* `inputRequest` contains form information, which could be used to prompt for user responses, and should only contain `properties`

### Custom Type Schema

If you wish to enforce or provide a predictable schema for a category of objects, you can specify the `type` as a JSON object, like this:
    
    {
        "name":         "myNamespace/realEstate",
        "schemaUrl":    "http://example.com/link-to-a-skeleton-file.json"
    }

And that "skeleton" JSON file should contain an "empty" schema of what would be expected at minimum in the `properties` value.

    {
        "_feedDescription": "A skeleton JSON file for the myNamespace/realEstate IoTA type.",
        "_typeName":        "myNamespace/realEstate",
        "listPrice":        0,
        "rooms":            0,
        "agentOfSale":      "",
        "acreage":          "",
        "tags":             [],
        "dimensions":       {
            "length":   0,
            "width":    0
        }
    }
    
Note that anything beginning with an `_` will be ignored. These properties are to be used for making readable comments about the schema. For example, you could include `_listPrice` with the value "This describes the list price of the house" as a means of documentation within the schema, as valid JSON does not allow for javascript-style comments.
