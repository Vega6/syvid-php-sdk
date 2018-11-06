## SyVid PHP SDK

Get user's campaign and post videos to the campaign of SyVid from other integrated applications.   
This package is meant for internal use in Vega6 webware technologies.

---
### Using the Library

#### Installation

Intall library in PHP project using composer
```
composer require vega6/syvid-sdk
```

#### Using Library
```
$syvid = new SyVid();
```
#### set access token
```
$syvid->setAccessToken('access_token');
```

#### Get Campaigns
```php
$campaigns = $syvid->getCampaigns();
```

returns array of campaigns created by the authorised user.

### Upload Video
```
$upload = $syvid->uploadVideo('campaign_id', 'title', 'description', 'video_path');
```
Call this endpoint to upload videos to the campaign.

By default the video will initiate distribution as soon as upload is complete.  
If you don't want to initiate the upload and just want to upload the video, pass last parameter in `uploadVideo` to `false`
```
$upload = $syvid->uploadVideo('campaign_id', 'title', 'description', 'video_path', false);
```

---

### Exception Handling
_Ex:_
```
try {
    $syvid->uploadVideo();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
```

---
### Bug Reporting

If you found any bug, create an [issue](https://github.com/Vega6/syvid-sdk/issues/new).

---
### Support and Contribution

Something is missing? 
* `Fork` the repositroy
* Make your contribution
* make a `pull request`
