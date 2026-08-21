<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom Session Files Driver
 *
 * Menghapus panggilan touch() pada updateTimestamp() dan write() agar
 * file session TIDAK diperbarui mtime-nya saat user idle.
 *
 * Akibatnya, PHP Garbage Collection dapat menghapus session file yang
 * sudah melewati sess_expiration (7200 detik / 2 jam) tanpa aktivitas,
 * sehingga user akan otomatis logout.
 */
class MY_Session_files_driver extends CI_Session_files_driver {

	/**
	 * Fingerprint snapshot dari read() terakhir.
	 * Digunakan untuk mendeteksi apakah session data berubah.
	 */
	private $_my_fingerprint;

	/**
	 * Override read() untuk menyimpan fingerprint sendiri.
	 */
	public function read($session_id)
	{
		$data = parent::read($session_id);
		$this->_my_fingerprint = md5($data);
		return $data;
	}

	/**
	 * Override updateTimestamp() - JANGAN lakukan apa-apa.
	 *
	 * Versi asli CI3 memanggil touch() yang memperbarui mtime file,
	 * sehingga PHP GC tidak pernah menganggap session expired.
	 * Dengan mengosongkan method ini, mtime hanya diperbarui oleh
	 * write() saat session data benar-benar berubah.
	 */
	public function updateTimestamp($id, $unknown)
	{
		return true;
	}

	/**
	 * Override write() - skip touch() saat data tidak berubah.
	 *
	 * Versi asli CI3 memanggil touch() saat fingerprint match (data
	 * tidak berubah), yang juga mencegah session expire. Method ini
	 * meniru logika parent tetapi tanpa touch() di fingerprint match.
	 */
	public function write($session_id, $session_data)
	{
		if ($session_id !== $this->_session_id && ($this->close() === $this->_failure OR $this->read($session_id) === $this->_failure))
		{
			return $this->_failure;
		}

		if ( ! is_resource($this->_file_handle))
		{
			return $this->_failure;
		}

		// Fingerprint match = data tidak berubah.
		// Versi asli: touch() file → mencegah expire.
		// Versi custom: SKIP touch → mtime tidak diupdate → expire bisa terjadi.
		if ($this->_fingerprint === md5($session_data))
		{
			return $this->_success;
		}

		if ( ! $this->_file_new)
		{
			ftruncate($this->_file_handle, 0);
			rewind($this->_file_handle);
		}

		if (($length = strlen($session_data)) > 0)
		{
			for ($written = 0, $result = 0; $written < $length; $written += $result)
			{
				if (($result = fwrite($this->_file_handle, substr($session_data, $written))) === FALSE)
				{
					break;
				}
			}

			if ( ! is_int($result))
			{
				$this->_fingerprint = md5(substr($session_data, 0, $written));
				log_message('error', 'Session: Unable to write data.');
				return $this->_failure;
			}
		}

		$this->_fingerprint = md5($session_data);
		return $this->_success;
	}
}
