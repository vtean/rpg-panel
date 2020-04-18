<?php
/**
 * @brief Families controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

class FamiliesController extends Controller
{
    private $familyModel;
    private $privileges;

    public function __construct()
    {
        // load model
        $this->familyModel = $this->loadModel('Family');

        // store privileges
        $this->privileges = $this->checkPrivileges();
    }

    public function index()
    {
        global $lang;
        $badges = $this->badges();
        $families = $this->familyModel->getFamilies();

        $data = [
            'pageTitle' => 'Families',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'lang' => $lang,
            'badges' => $badges,
            'families' => $families
        ];

        // load view
        $this->loadView('families_index', $data);
    }

    public function view($id = 0)
    {
        global $lang;
        $badges = $this->badges();
        $family = $this->familyModel->getFamily($id);

        if ($id != 0 && !empty($family)) {
            $famTypes = ["None", "Family", "Crew", "Squad", "Corporation", "Dynasty", "Empire", "Brotherhood"];
            $family['familyType'] = $famTypes[$family['type']];

            $data = [
                'pageTitle' => 'Families',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'lang' => $lang,
                'badges' => $badges,
                'family' => $family
            ];

            // load view
            $this->loadView('family_view', $data);
        } else {
            $this->error('404', 'Page Not Found!');
        }

    }
}