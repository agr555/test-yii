             // ��������� ������ ���������
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Qwaqwa123!');
define('DB_NAME', 'bookstore');
define('DB_TABLE_VERSIONS', 'versions');
 
 
// ������������ � ���� ������
function connectDB() {
    $errorMessage = '���������� ������������ � ������� ���� ������';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn)
        throw new Exception($errorMessage);
    else {
        $query = $conn->query('set names utf8');
        if (!$query)
            throw new Exception($errorMessage);
        else
            return $conn;
    }
}
 
 
// �������� ������ ������ ��� ��������
// �������� ������ ������ ��� ��������
function getMigrationFiles($conn) {
    // ������� ����� � ����������
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    // �������� ������ ���� sql-������
    $allFiles = glob($sqlFolder . '*.sql');
 
    // ���������, ���� �� ������� versions 
    // ��� ��� versions ��������� ������, �� ��� ����������� ����, ��� ���� �� ������
    $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $data = $conn->query($query);
    $firstMigration = !$data->num_rows;
     
    // ������ ��������, ���������� ��� ����� �� ����� sql
    if ($firstMigration) {
        return $allFiles;
    }
 
    // ���� ��� ������������ ��������
    $versionsFiles = array();
    // �������� �� ������� versions ��� �������� ������
    $query = sprintf('select `name` from `%s`', DB_TABLE_VERSIONS);
    $data = $conn->query($query)->fetch_all(MYSQLI_ASSOC);
    // �������� �������� � ������ $versionsFiles
    // �� �������� ��������� ������ ���� � �����
    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }
 
    // ���������� �����, ������� ��� ��� � ������� versions
    return array_diff($allFiles, $versionsFiles);
}
 
 
// ���������� �������� �����
function migrate($conn, $file) {
    // ��������� ������� ���������� mysql-������� �� �������� �����
    $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', DB_USER, DB_PASSWORD, DB_HOST, DB_NAME, $file);    
    // ��������� shell-������
    shell_exec($command);
 
    // ����������� ��� �����, �������� ����
    $baseName = basename($file);
    // ��������� ������ ��� ���������� �������� � ������� versions
    $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
    // ��������� ������
    $conn->query($query);
}
 
 
// ��������
 
// ������������ � ����
$conn = connectDB();
 
// �������� ������ ������ ��� �������� �� ����������� ���, ������� ��� ���� � ������� versions
$files = getMigrationFiles($conn);
 
// ���������, ���� �� ����� ��������
if (empty($files)) {
    echo '���� ���� ������ � ���������� ���������.';
} else {
    echo '�������� ��������...<br><br>';
 
    // ���������� �������� ��� ������� �����
    foreach ($files as $file) {
        migrate($conn, $file);
        // ������� �������� ������������ �����
        echo basename($file) . '<br>';
    }
 
    echo '<br>�������� ���������.';    
}