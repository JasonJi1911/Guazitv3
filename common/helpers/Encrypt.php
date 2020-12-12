<?php
namespace common\helpers;
/**
 * 加密工具类
 */
class Encrypt {
    // 偏移量
	const ENCRYPT_KEY = 'xAFC6RR8Nt3q1Ixx';
	const ENCRYPT_SECRET = 'RsR6NbLh4H2zEUSU';

	/** @inheritdoc */
	public function encrypt($text) {
		return openssl_encrypt($text, 'AES-128-CBC', self::ENCRYPT_KEY, 0, self::ENCRYPT_SECRET);
	}

	/** @inheritdoc */
	public function decrypt($cipherText, $key) {
		return openssl_decrypt($cipherText, 'AES-128-CBC', self::ENCRYPT_KEY, 0, self::ENCRYPT_SECRET);
	}

}

