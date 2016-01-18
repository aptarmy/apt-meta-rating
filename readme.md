# Post Star Rating
This plug-in is for WordPress theme made by AptTheme. It cannot be used within other themes.

---

## How to use this plug-in ?
Add this code in template-tags.php included by functions.php file to show Post Views in template.

`
function brawo_post_rating() {
	if (function_exits('apt_meta_rating_get')) {
		apt_meta_rating_get();
	} else {
		_e('Please install required plug-ins to show Post-Star-Rating.', 'user hasn\'t yet installed APT Meta Views', 'brawo' );
	}
}
`
