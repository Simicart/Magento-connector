<?php

class Simi_Simipromoteapp_Helper_Content extends Mage_Core_Helper_Abstract
{
    public function getRegisterSubject(){
        return 'Bravo! Mobile-only promo are waiting for you.';
    }

    public function getRegisterContent(){
        return 'Howdy,
                <br />Welcome you to join us!<br /><br />
                But wait...<br />
                Your journey is almost done, only one more step to get a pocketful of great shopping moments with us. Yah, whether you want to shop in the palm of your hand, you are golden with our mega-convenient app.<br /><br />
                By downloading our app, you can:
                <br />- Shop hundreds of products at your fingertips, literally.
                <br />- Never miss out the hottest products & best deals for mobile only by checking notifications.
                <br />- Order your goodies anytime and anywhere with a variety of payment methods.
                <br />- No need to keep checking your balance manually, mobile passbook will do that job.
                <br /><br /><strong>Wait no more!</strong> Enjoy shopping with our app  right NOW: {{if ios_link}}<a href="{{htmlescape var=\$ios_link}}" target="_blank" title="iOs app">iTune</a>{{/if}}  {{if ios_link}}<a href="{{htmlescape var=\$android_link}}" target="_blank" title="Android app">Android</a>{{/if}}
                <img style="display: none;" src="{{htmlescape var=\$log_link}}" alt="" width="0" height="0" border="0" />';
    }

    public function getSubscriberSubject(){
        return 'Thanks for visiting! Mobile-only promo are waiting for you.';
    }

    public function getSubscriberContent(){
        return 'Howdy,<br />
                Thank you for stopping by!<br /><br />
                We hope you"ve had an enjoyable time on your recent visit to our website. Found something you liked? Save it for later by adding it to your personal wishlist or cart.<br />
                <br />Still on the fence?<br /><br />
                Any time you want to shop with us, let our app stays on your phone home screen and give you a pocketful of great shopping moments. Yah, whether you want to shop in the palm of your hand, you are golden with our mega-convenient app.<br />
                <br />By downloading our app, you can:
                <br />- Shop hundreds of products at your fingertips, literally.
                <br />- Never miss out the hottest products & best deals for mobile only by checking notifications.
                <br />- Order your goodies anytime and anywhere with a variety of payment methods.
                <br />- No need to keep checking your balance manually, mobile passbook will do that job.
                <br /><br /><strong>Wait no more!</strong> Enjoy shopping with our app  right NOW: {{if ios_link}}<a href="{{htmlescape var=\$ios_link}}" target="_blank" title="iOs app">iTune</a>{{/if}}  {{if ios_link}}<a href="{{htmlescape var=\$android_link}}" target="_blank" title="Android app">Android</a>{{/if}}
                <img style="display: none;" src="{{htmlescape var=\$log_link}}" alt="" width="0" height="0" border="0" />';

    }

    public function getPurchasingSubject(){
        return 'Bing! Never miss the latest items again.';
    }

    public function getPurchasingContent(){
        return 'Howdy,<br />
                Thanks for your interest in our products!<br /><br />
                But wait...<br />
                Is it hard for you to shop online by scrolling our website on your gadgets? It must be and it can be very time consuming. Yah, whether you want to shop in the palm of your hand, you are golden with our mega-convenient app.<br /><br />
                By downloading our app, you can:
                <br />- Shop hundreds of products at your fingertips, literally.
                <br />- Never miss out the hottest products & best deals for mobile only by checking notifications.
                <br />- Order your goodies anytime and anywhere with a variety of payment methods.
                <br />- No need to keep checking your balance manually, mobile passbook will do that job.
                <br /><br /><strong>Wait no more!</strong> Enjoy shopping with our app  right NOW: {{if ios_link}}<a href="{{htmlescape var=\$ios_link}}" target="_blank" title="iOs app">iTune</a>{{/if}}  {{if ios_link}}<a href="{{htmlescape var=\$android_link}}" target="_blank" title="Android app">Android</a>{{/if}}
                <img style="display: none;" src="{{htmlescape var=\$log_link}}" alt="" width="0" height="0" border="0" />';

    }

    public function getCMSContent(){
        return '<div class="landing-shop-page">
<div id="download-app" class="section-01">
<div class="wrap-background">
<div class="container">
<div class="row">
<div class="col-md-7 col-sm-6">
<div class="title-page">Shop right on the palm of your hand!</div>
<div class="sub-title-page">
<div class="row">
<div class="col-md-9">It\'s super-easy, quick &amp; convenient to shop for your desired items via mobile apps effortlessly anywhere, anytime.<br />Never miss out on that latest item and best promotion deals again. <br />Hurry up and enjoy shopping with our mobile apps today!</div>
</div>
</div>
<div class="download-icon">
<div class="row">
<div class="col-md-5 col-sm-8">
<div class="button-actions"><a class="ios-button" href="#"><span class="wrap-a"><strong>Download App</strong><span>From App Store</span></span></a> <a class="android-button" href="#"><span class="wrap-a"><strong>Download App</strong><span>From Play Store</span></span></a></div>
</div>
<div class="col-md-4 col-sm-8">
<div class="wrap-qr"><img title="" src="{{skin url=\'images/shopapp/qr-code.png\'}}" alt="" /> <span class="title-qr-code">Scan to download this app</span></div>
</div>
</div>
</div>
</div>
<div class="col-md-4 col-sm-6 col-md-offset-1">
<div class="wrap-image">{{block type="core/template" data_type="1" template="simipromoteapp/cms.phtml"}}</div>
</div>
</div>
</div>
</div>
</div>
<div class="section-02">
<div class="wrap-background">
<div class="container">
<div class="row">
<div class="col-md-6 col-sm-7">
<div class="wrap-image">{{block type="core/template" data_type="2" template="simipromoteapp/cms.phtml"}}</div>
</div>
<div class="col-md-6 col-sm-5">
<h3 class="title-box">Shop at Young FingerTips with Ease</h3>
<ul>
<li><span>Easily browse over hundreds of items in our catalog.</span></li>
<li><span>Our filters make it simple to find exactly what you want. </span></li>
<li><span>Sort by brand, category, size, colour and price.</span></li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="section-03">
<div class="wrap-background">
<div class="container">
<div class="row">
<div class="col-md-5">
<h3 class="title-box">Never Miss Best Deals <br />and All Latest Items</h3>
<span>Get instant updates on the latest products, hottest trends and offers personalized for your interest! Not only is it time efficient but you can experience the same feel of shopping on the go.</span></div>
<div class="col-md-6 col-md-offset-1">
<div class="wrap-image">{{block type="core/template" data_type="4" template="simipromoteapp/cms.phtml"}}
<div class="more-image">{{block type="core/template" data_type="3" template="simipromoteapp/cms.phtml"}}</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="section-04">
<div class="wrap-background">
<div class="container">
<div class="row">
<div class="col-md-12">
<h3 class="title-box">Checkout Quickly and Safely</h3>
<span class="title-sub">Order your new goodies with fast, safe and convenient payment methods: cash-on-delivery, credit card, bank transfer, PayPal, 2Checkout and more.</span></div>
<div class="col-md-4">
<div class="wrap-image">{{block type="core/template" data_type="5" template="simipromoteapp/cms.phtml"}}</div>
</div>
<div class="col-md-4">
<div class="wrap-image2"><img class="second-img" title="" src="{{skin url=\'images/shopapp/bg-image-04-02.png\'}}" alt="" /></div>
</div>
<div class="col-md-4">
<div class="wrap-image3"><img class="third-img" title="" src="{{skin url=\'images/shopapp/bg-image-04-03.png\'}}" alt="" /></div>
</div>
</div>
</div>
</div>
</div>
<div class="section-05">
<div class="wrap-background">
<div class="container">
<div class="row">
<div class="col-md-12">
<h3 class="title-box">Let Us Be With You Anytime, Anywhere!</h3>
<div class="actions"><a title="Get App Now" href="#download-app"><span>Get App Now</span></a></div>
</div>
</div>
</div>
</div>
</div>
</div>';
    }
}