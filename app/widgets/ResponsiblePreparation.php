<?

namespace widgets;

use core\DB;

class ResponsiblePreparation
{
    protected $pdo;

    public function __construct() {
        $this->pdo = DB::getPDO();
    }

    public function getResponsiblesPreparationByPermissionId($permissionId) {
        $query = "SELECT * FROM get_responsibles_preparation_by_permission_id(:permission_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId));

        return $stmt->fetchAll();
    }

    public function getResponsiblesPreparationByPermissionIdSearch($permissionId, $search) {
        $search = '%' . $search . '%';
        $query = "SELECT * FROM get_responsibles_preparation_by_permission_id_search(:permission_id, :search)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array('permission_id' => $permissionId, 'search' => $search));

        return $stmt->fetchAll();
    }
}