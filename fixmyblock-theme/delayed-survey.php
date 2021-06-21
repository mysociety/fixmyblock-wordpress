<?php

$base_survey_url = "https://mysociety.us9.list-manage.com/subscribe/post?u=53d0d2026dea615ed488a8834&amp;id=9334858efa&amp;";
$this_page = "SOURCE_URL=" . get_permalink(get_the_ID()) . ";";
$survey_url = $base_survey_url . $this_page;

?>

<h3>Survey: Can we ask you later how you're doing?</h3>
<p>We'd like to follow up in a few weeks' time, to see whether there's been any progress on your issue,
 and to get your thoughts on how we can make FixMyBlock more helpful. If that sounds good, please enter 
 your email address below.</p>
<!-- Begin Mailchimp Signup Form -->
	<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css"
          rel="stylesheet" type="text/css">
	<style type="text/css">
	   #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}<br />
	   /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.<br />
	      We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */<br />
	</style>
	<div id="mc_embed_signup">
		<form action="<?= $survey_url ?>" class="validate" id="mc-embedded-subscribe-form" 
              method="post" name="mc-embedded-subscribe-form" novalidate="" target="_blank">
			<div id="mc_embed_signup_scroll">
				<input class="email" id="mce-EMAIL" name="EMAIL" placeholder="email address" required="" type="email" value=""> 
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div aria-hidden="true" style="position: absolute; left: -5000px;">
					<input name="b_53d0d2026dea615ed488a8834_9334858efa" tabindex="-1" type="text" value="">
				</div>
				<div class="clear">
					<input class="button" id="mc-embedded-subscribe" name="subscribe" type="submit" value="Signup for survey">
				</div>
			</div>
		</form>
	</div>
    <!--End mc_embed_signup-->