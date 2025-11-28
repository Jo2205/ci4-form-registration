<?php

namespace App\Controllers;

class TestDB extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();

            echo "<h2>Test Koneksi Database PostgreSQL</h2>";
            echo "<hr>";

            // Test koneksi
            if ($db->connect()) {
                echo "✅ <strong>Koneksi database BERHASIL!</strong><br><br>";
                echo "Database Name: <strong>" . $db->getDatabase() . "</strong><br>";
                echo "Database Platform: <strong>" . $db->getPlatform() . "</strong><br>";
                echo "Database Version: <strong>" . $db->getVersion() . "</strong><br><br>";

                // Test query ke tabel users
                echo "<hr>";
                echo "<h3>Test Query Tabel Users:</h3>";
                $query = $db->query("SELECT COUNT(*) as total FROM users");
                $result = $query->getRow();
                echo "✅ Jumlah data di tabel users: <strong>" . $result->total . "</strong><br>";
            } else {
                echo "❌ <strong>Koneksi database GAGAL!</strong><br>";
                print_r($db->error());
            }
        } catch (\Exception $e) {
            echo "❌ <strong>ERROR:</strong> " . $e->getMessage();
        }
    }
}
