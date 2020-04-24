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

    public function __construct()
    {
        parent::__construct();

        // load model
        $this->familyModel = $this->loadModel('Family');
    }

    public function index()
    {
        $families = $this->familyModel->getFamilies();

        $data = [
            'pageTitle' => 'Families',
            'families' => $families
        ];

        // load view
        $this->loadView('families_index', $data);
    }

    public function view($id = 0)
    {
        $family = $this->familyModel->getFamily($id);

        if ($id != 0 && !empty($family)) {
            $famTypes = ["None", "Family", "Crew", "Squad", "Corporation", "Dynasty", "Empire", "Brotherhood"];
            $family['familyType'] = $famTypes[$family['type']];

            $data = [
                'pageTitle' => 'Families',
                'family' => $family
            ];

            // load view
            $this->loadView('family_view', $data);
        } else {
            $this->error('404', 'Page Not Found!');
        }

    }
}