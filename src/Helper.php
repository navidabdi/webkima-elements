<?php

namespace WebkimaElements;

class Helper {

	public static function getTheExcerpt($excerpt, $length = 40): string {
		$excerpt = substr($excerpt, 0, $length * 10);

		return substr($excerpt, 0, strrpos($excerpt, ' ')) . ' ...';
	}

}