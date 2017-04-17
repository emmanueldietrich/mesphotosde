<?php
namespace ED\AlbumBundle\Tools;

class EDSlugify
{
	/**
	 * Renvoit le slug d'une chaine de caractère
	 * http://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string#comment47960679_2955251
	 *
	 * @param string $text
	 * @return string $slug
	 */
	public function slugThis($text)
	{
		// replace non letter or digits by -
		$slug = preg_replace('~[^\pL\d]+~u', '-', $text);
		
		// transliterate
		$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		
		// remove unwanted characters
		$slug = preg_replace('~[^-\w]+~', '', $text);
		
		// trim
		$slug = trim($text, '-');
		
		// remove duplicate -
		$slug = preg_replace('~-+~', '-', $text);
		
		// lowercase
		$slug = strtolower($text);
		
		if (empty($text)) {
			return 'n-a';
		}
		
		return $slug;
	}
}