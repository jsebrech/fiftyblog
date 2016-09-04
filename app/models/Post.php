<?php

class Post {

  public $title = "";
  public $body = "";
  public $created = null;

  function __construct($title, $created, $body) {
    $this->title = $title;
    $this->body = $body;
    $this->created = $created;
  }

  static function get($from, $count = 1) {
    return array_slice(array_filter(Post::all(), function($post) use ($from) {
      return !$from || ($post->created <= (int) $from);
    }), 0, $count);
  }

  static function all() {
    $posts = [];

    $posts[] = new Post(
      "Worth A Thousand Words",
      mktime(12, 0, 0, 1, 1, 2016),
      <<<EOT
        <figure class="figure" style="width: 435px" class="figure">
          <img alt="Boat" class="figure-img img-fluid img-rounded" src="https://wpdotorg.files.wordpress.com/2008/11/boat.jpg" width="435" height="288" />
          <figcaption class="figure-caption">Boat</figcaption>
        </figure>
EOT
    );

    $posts[] = new Post(
      "Elements",
      mktime(11, 0, 0, 1, 1, 2016),
      <<<EOT
<p>The purpose of this HTML is to help determine what default settings are with CSS and to make sure that all possible HTML Elements are included in this HTML so as to not miss any possible Elements when designing a site.</p>
<hr />
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>
<hr />
<h2 id="paragraph">Paragraph</h2>
<p>Lorem ipsum dolor sit amet, <a href="#" title="test link">test link</a> adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.</p>
<p>Lorem ipsum dolor sit amet, <em>emphasis</em> consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.</p>
<hr />
<h2 id="list_types">List Types</h2>
<h3>Definition List</h3>
<dl>
<dt>Definition List Title</dt>
<dd>This is a definition list division.</dd>
</dl>
<h3>Ordered List</h3>
<ol>
<li>List Item 1</li>
<li>List Item 2</li>
<li>List Item 3</li>
</ol>
<h3>Unordered List</h3>
<ul>
<li>List Item 1</li>
<li>List Item 2</li>
<li>List Item 3</li>
</ul>
<hr />
<h2 id="form_elements">Forms</h2>
<fieldset>
<legend>Legend</legend>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus.</p>
<form>
<h2>Form Element</h2>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui.</p>
<p><label for="text_field">Text Field:</label><br />
		<input type="text" id="text_field" /></p>
<p><label for="text_area">Text Area:</label><br />
		<textarea id="text_area"></textarea></p>
<p><label for="select_element">Select Element:</label><br />
			<select name="select_element"><br />
			<optgroup label="Option Group 1"><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></optgroup></p>
<p>			<optgroup label="Option Group 2"><option value="1">Option 1</option><option value="2">Option 2</option><option value="3">Option 3</option></optgroup><br />
		</select></p>
<p><label for="radio_buttons">Radio Buttons:</label></p>
<p>			<input type="radio" class="radio" name="radio_button" value="radio_1" /> Radio 1<br />
				<input type="radio" class="radio" name="radio_button" value="radio_2" /> Radio 2<br />
				<input type="radio" class="radio" name="radio_button" value="radio_3" /> Radio 3
		</p>
<p><label for="checkboxes">Checkboxes:</label></p>
<p>			<input type="checkbox" class="checkbox" name="checkboxes" value="check_1" /> Radio 1<br />
				<input type="checkbox" class="checkbox" name="checkboxes" value="check_2" /> Radio 2<br />
				<input type="checkbox" class="checkbox" name="checkboxes" value="check_3" /> Radio 3
		</p>
<p><label for="password">Password:</label></p>
<p>			<input type="password" class="password" name="password" />
		</p>
<p><label for="file">File Input:</label><br />
			<input type="file" class="file" name="file" />
		</p>
<p><input class="button" type="reset" value="Clear" /> <input class="button" type="submit" value="Submit" />
		</p>
</p></form>
</fieldset>
<hr />
<h2 id="tables">Tables</h2>
<table cellspacing="0" cellpadding="0">
<tr>
<th>Table Header 1</th>
<th>Table Header 2</th>
<th>Table Header 3</th>
</tr>
<tr>
<td>Division 1</td>
<td>Division 2</td>
<td>Division 3</td>
</tr>
<tr class="even">
<td>Division 1</td>
<td>Division 2</td>
<td>Division 3</td>
</tr>
<tr>
<td>Division 1</td>
<td>Division 2</td>
<td>Division 3</td>
</tr>
</table>
<hr />
<h2 id="misc">Misc Stuff &#8211; abbr, acronym, pre, code, sub, sup, etc.</h2>
<p>Lorem <sup>superscript</sup> dolor <sub>subscript</sub> amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. <cite>cite</cite>. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. <acronym title="National Basketball Association">NBA</acronym> Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.  <abbr title="Avenue">AVE</abbr></p>
<pre>
<p>
Lorem ipsum dolor sit amet,
 consectetuer adipiscing elit.
 Nullam dignissim convallis est.
 Quisque aliquam. Donec faucibus.
Nunc iaculis suscipit dui.
Nam sit amet sem.
Aliquam libero nisi, imperdiet at,
 tincidunt nec, gravida vehicula,
 nisl.
Praesent mattis, massa quis
luctus fermentum, turpis mi
volutpat justo, eu volutpat
enim diam eget metus.
Maecenas ornare tortor.
Donec sed tellus eget sapien
 fringilla nonummy.
<acronym title="National Basketball Association">NBA</acronym>
Mauris a ante. Suspendisse
 quam sem, consequat at,
commodo vitae, feugiat in,
nunc. Morbi imperdiet augue
 quis tellus.
<abbr title="Avenue">AVE</abbr></p></pre>
<blockquote><p>
	&#8220;This stylesheet is going to help so freaking much.&#8221; <br />-Blockquote
</p></blockquote>
EOT
    );

    for ($i = 10; $i >= 1; $i--) {
      $posts[] = new Post("Post " . $i, mktime($i, 0, 0, 1, 1, 2016), "Blah");
    }
    return $posts;
  }
}
