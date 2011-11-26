# &lt;DOCTYPEhtml.net&gt; - HTML5 Demos and Experiments

This is a small demonstration of what can be done with HTML5 and CSS3. Not every technique listed as HTML5 demo is actually part of the HTML5 standard. Geolocation API and File API for example are their very own standards but are often mentioned in connection with HTML5. So they're listed here as well. You can use the code in your projects, all examples are under WTFPL. This showcase is work in progress. More demos will follow soon, so check back often!

## NEW: add your own demos

Fork this repository, use the `DEMO-TEMPLATE` folder in `/assets` to create your own awesome demo, put it in the `/html5` or `/css3` folder and send a pull request. In case your demo is cool I will publish it on http://doctypehtml.net

## Howto: adding your own demo

### DEMO-TEMPLATE/meta.js

All the meta information goes here. The title/subtitle to be shown on the homepage, browser compatibility information and – honour to whom honour is due – your name and URL.

### DEMO-TEMPLATE/example.html

This is the place for all your demo markup. Everything inside of your documents `<head></head>` and inside of the `<section id="content"></section>` will be visible in the output. Don't forget to link your external stylesheets and javascripts if you're using some. You can use the `[[url]]` placeholder. It will be replaced by the current demo's URL. For example: if you want to link a stylesheet in `/html5/mydemo/css/mydemo.css` you should use `[[url]]/css/mydemo.css`. Just have a look at the existing demos.

### DEMO-TEMPLATE/css and DEMO-TEMPLATE/js

This is where your external stylesheets and javascripts go. They should have the same name as your demo folder. So in case your demo folder is called `mydemo` they should (but don't have to) be named `css/mydemo.css` and `js/mydemo.js`.
