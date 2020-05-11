<p>This is an example of using the PHP-function <code>make_clickable()</code>. The function takes a text as argument and looks through it using a regular expression. The expression matches all <a href="http://sv.wikipedia.org/wiki/Uniform_Resource_Locator">URLs</a> that are in the text and makes them clickable, without messing up the links that are already there. </p>

<p>The url must start with <b>http</b> or <b>https</b>. The regular expression ignores all links that are already available within an existing anchor (href) or iframe (src).</p>

<p>This link should for example be made clickable: http://dbwebb.se and so should this link http://dbwebb.se/kod-exempel/function_to_make_links_clickable/ and so should this: http://dbwebb.se/kod-exempel/function_to_make_links_clickable#id.</p>

<p>The initial code came from Wordpress where such function exists. The function was then <a href="/t/254">modified in this forumthread</a>.</p>

<h3>More tests</h3>

<p>Here are some URLs:
stackoverflow.com/questions/1188129/pregreplace-to-detect-html-php
Here's the answer: http://www.google.com/search?rls=en&q=42&ie=utf-8&oe=utf-8&hl=en. What was the question?
A quick look at http://en.wikipedia.org/wiki/URI_scheme#Generic_syntax is helpful.
There is no place like 127.0.0.1! Except maybe http://news.bbc.co.uk/1/hi/england/surrey/8168892.stm?
Ports: 192.168.0.1:8080, https://example.net:1234/.
Beware of Greeks bringing internationalized top-level domains: xn--hxajbheg2az3al.xn--jxalpdlp.
And remember.Nobody is perfect.
