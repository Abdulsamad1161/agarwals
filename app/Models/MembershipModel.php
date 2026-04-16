<?php
namespace App\Models;

use CodeIgniter\Model;

class MembershipModel extends BaseModel
{
    protected $builderUsers;
    protected $builderRoles;
    protected $builderMembershipPlans;
    protected $builderMembershipPlansUsers;
    protected $builderUsersMembershipPlans;
    protected $builderUsersMembershipPlansSubs;
    protected $builderMembershipTransactions;
    protected $builderMembershipTransactionsUsers;
    protected $builderBoardDirectors;
    protected $builderBoardDirectorsSub;
    protected $builderSponsorshipEnquiry;
    protected $builderContactUsForm;
    protected $builderOurSponsorsList;

    public function __construct()
    {
        parent::__construct();
        $this->builderUsers = $this->db->table('users');
        $this->builderUsersDelete = $this->db->table('users_delete');
        $this->builderRoles = $this->db->table('roles_permissions');
        $this->builderMembershipPlans = $this->db->table('membership_plans');
        $this->builderMembershipPlansUsers = $this->db->table('membership_plans_users');
        $this->builderUsersMembershipPlans = $this->db->table('users_membership_plans');
        $this->builderUsersMembershipPlansSubs = $this->db->table('users_membership_plans_subs');
        $this->builderMembershipTransactions = $this->db->table('membership_transactions');
        $this->builderMembershipTransactionsUsers = $this->db->table('membership_transactions_users_subs');
        $this->builderBoardDirectors = $this->db->table('board_of_directors');
        $this->builderBoardDirectorsSub = $this->db->table('old_board_of_directors');
        $this->builderContactUsForm = $this->db->table('contact_us_form_data');
        $this->builderSponsorshipEnquiry = $this->db->table('sponsrship_enquiry_form_data');
        $this->builderOurSponsorsList = $this->db->table('sponsors_list');
    }

    //get users count
    public function getUserCount()
    {
        $this->filterUsers();
        return $this->builderUsers->countAllResults();
    }

    //get paginated users
    public function getPaginatedUsers()
    {
        $member = inputGet('isMember');
        $memberMigrarted = inputGet('isMigration');
        if (!empty($member)) {
            $this->builderUsers->join('users_membership_plans_subs', 'users.id = users_membership_plans_subs.user_id');
            //$this->builderUsers->where('users_membership_plans_subs.payment_method', 'Migration');
            $this->builderUsers->select('users_membership_plans_subs.payment_method, users.*');
            //$this->builderUsers->where('users_membership_plans_subs.deleted', 0);
            $this->builderUsers->groupBy('users.id');

            $emailStatus = inputGet('email_status');
            if (!empty($emailStatus)) {
                $status = $emailStatus == 'confirmed' ? 1 : 0;
                $this->builderUsers->where('users.email_status', $status);
            }
        } elseif (!empty($memberMigrarted)) {
            $this->builderUsers->join('users_membership_plans_subs', 'users.id = users_membership_plans_subs.user_id');
            $this->builderUsers->where('users_membership_plans_subs.payment_method', 'Migration');
            $this->builderUsers->select('users_membership_plans_subs.payment_method, users.*');
            //$this->builderUsers->where('users_membership_plans_subs.deleted', 0);
            $this->builderUsers->groupBy('users.id');

            $emailStatus = inputGet('email_status');
            if (!empty($emailStatus)) {
                $status = $emailStatus == 'confirmed' ? 1 : 0;
                $this->builderUsers->where('users.email_status', $status);
            }
        } else {
            $this->filterUsers();
        }
        return $this->builderUsers->orderBy('users.id DESC')->get()->getResult();
    }

    //get paginated users
    public function getUsersToSendEmail($emailStatus)
    {
        $this->builderUsers->join('users_membership_plans_subs', 'users.id = users_membership_plans_subs.user_id');
        $this->builderUsers->where('users_membership_plans_subs.payment_method', 'Migration');
        $this->builderUsers->select('users_membership_plans_subs.payment_method, users.*');
        $this->builderUsers->where('users_membership_plans_subs.deleted', 0);

        if (!empty($emailStatus)) {
            $status = $emailStatus == 'confirmed' ? 1 : 0;
            $this->builderUsers->where('users.email_status', $status);
        }
        return $this->builderUsers->orderBy('created_at DESC')->get()->getResult();
    }

    //users filter
    public function filterUsers()
    {
        $emailStatus = inputGet('email_status');
        if (!empty($emailStatus)) {
            $status = $emailStatus == 'confirmed' ? 1 : 0;
            $this->builderUsers->where('users.email_status', $status);
        }
    }

    //add membership transaction
    public function addMembershipTransaction($dataTransaction, $plan)
    {
        $data = [
            'payment_method' => $dataTransaction['payment_method'],
            'payment_id' => $dataTransaction['payment_id'],
            'user_id' => user()->id,
            'plan_id' => $plan->id,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'payment_amount' => $dataTransaction['payment_amount'],
            'currency' => $dataTransaction['currency'],
            'payment_status' => $dataTransaction['payment_status'],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $planStartDate = date('Y-m-d');
        $planEndDate = '';

        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        $data['plan_expiry_date'] = $planEndDate;

        $data['plan_expiry_date'] = date('Y-m-d H:i:s', strtotime($data['plan_expiry_date']));
        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->builderMembershipTransactions->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());
            if (!isVendor()) {
                $this->builderUsers->where('id', user()->id)->update(['is_active_shop_request' => 1]);
            }
        }
    }

    //add membership transaction bank
    public function addMembershipTransactionBank($dataTransaction, $plan)
    {
        $price = getPrice($plan->price, 'decimal');
        $price = convertCurrencyByExchangeRate($price, getSelectedCurrency()->exchange_rate);
        $data = [
            'payment_method' => $dataTransaction['payment_method'],
            'payment_id' => $dataTransaction['payment_id'],
            'user_id' => user()->id,
            'plan_id' => $plan->id,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'payment_amount' => $price,
            'currency' => getSelectedCurrency()->code,
            'payment_status' => $dataTransaction['payment_status'],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->builderMembershipTransactions->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());
            if (!isVendor()) {
                $this->builderUsers->where('id', user()->id)->update(['is_active_shop_request' => 1]);
            }
        }
    }

    //add shop opening email
    public function addShopOpeningEmail()
    {
        if ($this->generalSettings->send_email_shop_opening_request == 1) {
            $emailData = [
                'email_type' => 'new_shop',
                'email_address' => $this->generalSettings->mail_options_account,
                'email_subject' => trans("shop_opening_request"),
                'template_path' => 'email/main',
                'email_data' => serialize([
                    'content' => trans("there_is_shop_opening_request") . '<br>' . trans("user") . ': ' . '<strong>' . getUsername(user()) . '</strong>',
                    'url' => adminUrl('shop-opening-requests'),
                    'buttonText' => trans("view_details")
                ])
            ];
            addToEmailQueue($emailData);
        }
    }

    //get membership transaction
    public function getMembershipTransaction($id)
    {
        return $this->builderMembershipTransactions->where('id', clrNum($id))->get()->getRow();
    }

    //get membership plan title
    public function getMembershipPlanTitle($plan)
    {
        $title = trans("membership_plan");
        if (!empty($plan)) {
            $title = getMembershipPlanName($plan->title_array, selectedLangId());
            $title .= ' (';
            if ($plan->is_unlimited_number_of_ads == 1) {
                $title .= trans("number_of_ads") . ': ' . trans("unlimited");
            } else {
                $title .= trans("number_of_ads") . ': ' . $plan->number_of_ads;
            }
            if ($plan->is_unlimited_time == 1) {
                $title .= ', ' . trans("number_of_days") . ': ' . trans("unlimited");
            } else {
                $title .= ', ' . trans("number_of_days") . ': ' . $plan->number_of_days;
            }
            $title .= ')';
        }
        return $title;
    }

    //add user plan
    public function addUserPlan($dataTransaction, $plan, $userId)
    {
        $oldPlan = $this->builderUsersMembershipPlans->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlans->where('user_id', clrNum($userId))->delete();
        }
        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'number_of_ads' => $plan->number_of_ads,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->paymentSettings->default_currency,
            'is_free' => $plan->is_free,
            'is_unlimited_number_of_ads' => $plan->is_unlimited_number_of_ads,
            'is_unlimited_time' => $plan->is_unlimited_time,
            'payment_method' => $dataTransaction['payment_method'],
            'payment_status' => $dataTransaction['payment_status'],
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d')
        ];
        if ($plan->is_unlimited_time == 1) {
            $data['plan_end_date'] = '';
        } else {
            $planStartDate = date('Y-m-d');

            // Assuming $duration is in the format "1 year"
            $durationParts = explode(' ', $plan->number_of_days);

            if (count($durationParts) === 2 && is_numeric($durationParts[0])) {
                $durationValue = $durationParts[0];
                $durationUnit = strtolower($durationParts[1]);

                // Calculate the end date by adding the duration to the start date
                $planEndDate = date('Y-m-d', strtotime($planStartDate . ' + ' . $durationValue . ' ' . $durationUnit));

                // Add the calculated end date
                $data['plan_start_date'] = $planStartDate;
                $data['plan_end_date'] = $planEndDate;
            }

        }
        if ($dataTransaction["payment_status"] == 'awaiting_payment') {
            $data['plan_status'] = 0;
        }

        $data['user_id'] = clrNum($userId);
        $this->builderUsersMembershipPlans->insert($data);

        //update user plan status
        $this->builderUsers->where('id', clrNum($userId))->update(['is_membership_plan_expired' => 0]);
    }

    //add user free plan
    public function addUserFreePlan($plan, $userId)
    {
        $oldPlan = $this->builderUsersMembershipPlans->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlans->where('user_id', clrNum($userId))->delete();
        }
        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'number_of_ads' => $plan->number_of_ads,
            'number_of_days' => $plan->number_of_days,
            'price' => 0,
            'currency' => $this->paymentSettings->default_currency,
            'is_free' => $plan->is_free,
            'is_unlimited_number_of_ads' => $plan->is_unlimited_number_of_ads,
            'is_unlimited_time' => $plan->is_unlimited_time,
            'payment_method' => '',
            'payment_status' => '',
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d H:i:s')
        ];
        if ($plan->is_unlimited_time == 1) {
            $data['plan_end_date'] = '';
        } else {
            $planStartDate = date('Y-m-d');

            // Assuming $duration is in the format "1 year"
            $durationParts = explode(' ', $plan->number_of_days);

            if (count($durationParts) === 2 && is_numeric($durationParts[0])) {
                $durationValue = $durationParts[0];
                $durationUnit = strtolower($durationParts[1]);

                // Calculate the end date by adding the duration to the start date
                $planEndDate = date('Y-m-d', strtotime($planStartDate . ' + ' . $durationValue . ' ' . $durationUnit));

                // Add the calculated end date
                $data['plan_start_date'] = $planStartDate;
                $data['plan_end_date'] = $planEndDate;
            }
        }

        $data['user_id'] = clrNum($userId);
        $this->builderUsersMembershipPlans->insert($data);

        //update user plan status
        $this->builderUsers->where('id', clrNum($userId))->update(['is_membership_plan_expired' => 0, 'is_used_free_plan' => 1]);
    }

    //get user plan by user id
    public function getUserPlanByUserId($userId, $onlyActive = true)
    {
        if ($onlyActive) {
            $this->builderUsersMembershipPlans->where('plan_status', 1);
        }
        return $this->builderUsersMembershipPlans->where('user_id', clrNum($userId))->get()->getRow();
    }

    //get user plan days remaining
    public function getUserPlanRemainingDaysCount($plan)
    {
        $daysLeft = 0;
        if (!empty($plan)) {
            if (!empty($plan->plan_end_date)) {
                $daysLeft = dateDifference($plan->plan_end_date, date('Y-m-d H:i:s'));
            }
        }
        return $daysLeft;
    }

    //get user plan by user id
    public function getUserPlanByUserIdUsers($userId, $onlyActive = true)
    {
        if ($onlyActive) {
            $this->builderUsersMembershipPlansSubs->where('plan_status', 1);
        }
        return $this->builderUsersMembershipPlansSubs->orderBy('id', 'desc')->limit('1')->where('user_id', clrNum($userId))->get()->getRow();
    }
    public function getUserPlanByUserIdUsersAge($userId, $onlyActive = true)
    {
        if ($onlyActive) {
            $this->builderUsersMembershipPlansSubs->where('plan_status', 1);
        }
        return $this->builderUsersMembershipPlansSubs
            ->where('user_id', clrNum($userId))
            ->orderBy('id', 'asc')
            ->limit(1)
            ->get()
            ->getRow();
    }

    //get user plan by user id
    public function getUserPlanByUserIdUsersPost($userId, $onlyActive = true)
    {
        if ($onlyActive) {
            $this->builderUsersMembershipPlansSubs->where('plan_status', 0);
        }
        return $this->builderUsersMembershipPlansSubs->where('deleted', 1)->orderBy('id', 'desc')->limit('1')->where('user_id', clrNum($userId))->get()->getRow();
    }

    //get user plan days remaining
    public function getUserPlanRemainingDaysCountUsers($plan)
    {
        $daysLeft = 0;
        if (!empty($plan)) {
            if (!empty($plan->plan_end_date)) {
                $daysLeft = dateDifference($plan->plan_end_date, date('Y-m-d H:i:s'));
            }
        }
        return $daysLeft;
    }

    //get user plan ads remaining
    public function getUserPlanRemainingAdsCount($plan)
    {
        $adsLeft = 0;
        if (!empty($plan)) {
            $productsCount = $this->getUserAdsCount($plan->user_id);
            $adsLeft = @($plan->number_of_ads - $productsCount);
            if (empty($adsLeft) || $adsLeft < 0) {
                $adsLeft = 0;
            }
        }
        return $adsLeft;
    }

    //get user ads count
    public function getUserAdsCount($userId)
    {
        return $this->db->table('products')->where('products.is_deleted', 0)->where('products.is_draft', 0)->where('products.user_id', clrNum($userId))->countAllResults();
    }

    //is allowed adding product
    public function isAllowedAddingProduct()
    {
        if (isSuperAdmin()) {
            return true;
        }
        if ($this->generalSettings->membership_plans_system == 1) {
            if (user()->is_membership_plan_expired == 1) {
                return false;
            }
            $userPlan = $this->getUserPlanByUserId(user()->id);
            if (!empty($userPlan)) {
                if ($userPlan->is_unlimited_number_of_ads == 1) {
                    return true;
                }
                if ($this->getUserPlanRemainingAdsCount($userPlan) > 0) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    //check membership plans expired
    public function checkMembershipPlansExpired()
    {
        $plans = $this->builderUsersMembershipPlans->join('users', 'users_membership_plans.user_id = users.id AND users.is_membership_plan_expired = 0')->select('users_membership_plans.*')->get()->getResult();
        if (!empty($plans)) {
            foreach ($plans as $plan) {
                if ($plan->is_unlimited_time != 1) {
                    if ($this->getUserPlanRemainingDaysCount($plan) <= -3) {
                        //update user plan status
                        $this->builderUsers->where('id', $plan->user_id)->update(['is_membership_plan_expired' => 1]);
                    }
                }
            }
        }
    }

    /*
     * --------------------------------------------------------------------
     * Back-end
     * --------------------------------------------------------------------
     */

    //prepare data
    public function preparePlanData()
    {
        $data = [
            'number_of_ads' => inputPost('number_of_ads'),
            'number_of_days' => inputPost('number_of_days'),
            'price' => inputPost('price'),
            'is_free' => inputPost('is_free'),
            'is_unlimited_number_of_ads' => inputPost('is_unlimited_number_of_ads'),
            'is_unlimited_time' => inputPost('is_unlimited_time'),
            'plan_order' => inputPost('plan_order'),
            'is_popular' => inputPost('is_popular')
        ];
        $arrayTitle = array();
        $arrayFeatures = array();
        foreach ($this->activeLanguages as $language) {
            //add titles
            $item = [
                'lang_id' => $language->id,
                'title' => inputPost('title_' . $language->id)
            ];
            array_push($arrayTitle, $item);
            //add features
            $features = inputPost('feature_' . $language->id);
            $array = array();
            if (!empty($features)) {
                foreach ($features as $feature) {
                    $feature = trim($feature ?? '');
                    if (!empty($feature)) {
                        array_push($array, $feature);
                    }
                }
            }
            $itemFeature = [
                'lang_id' => $language->id,
                'features' => $array
            ];
            array_push($arrayFeatures, $itemFeature);
        }
        $data['price'] = getPrice($data['price'], 'database');
        if (empty($data['price'])) {
            $data['price'] = 0;
        }
        $data['title_array'] = serialize($arrayTitle);
        $data['features_array'] = serialize($arrayFeatures);
        if (empty($data['number_of_ads'])) {
            $data['number_of_ads'] = 0;
        }
        if (empty($data['number_of_days'])) {
            $data['number_of_days'] = 0;
        }
        if (!empty($data['is_unlimited_number_of_ads'])) {
            $data['number_of_ads'] = 0;
        } else {
            $data['is_unlimited_number_of_ads'] = 0;
        }
        if (!empty($data['is_unlimited_time'])) {
            $data['number_of_days'] = 0;
        } else {
            $data['is_unlimited_time'] = 0;
        }
        if (!empty($data['is_free'])) {
            $data['price'] = 0;
        } else {
            $data['is_free'] = 0;
        }
        //update other plans
        if (!empty($data['is_popular'])) {
            $this->builderMembershipPlans->update(['is_popular' => 0]);
        } else {
            $data['is_popular'] = 0;
        }
        return $data;
    }

    //add plan
    public function addPlan()
    {
        $data = $this->preparePlanData();
        return $this->builderMembershipPlans->insert($data);
    }

    //edit plan
    public function editPlan($id)
    {
        $plan = $this->getPlan($id);
        if (!empty($plan)) {
            $data = $this->preparePlanData();
            return $this->builderMembershipPlans->where('id', $plan->id)->update($data);
        }
        return false;
    }

    //get plan
    public function getPlan($id)
    {
        return $this->builderMembershipPlans->where('id', clrNum($id))->get()->getRow();
    }

    //get plans
    public function getPlans()
    {
        return $this->builderMembershipPlans->orderBy('plan_order')->get()->getResult();
    }

    //update settings
    public function updateSettings()
    {
        $data = [
            'membership_plans_system' => inputPost('membership_plans_system')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //get membership transactions count
    public function getMembershipTransactionsCount($userId)
    {
        $this->filterTransactions($userId);
        return $this->builderMembershipTransactions->countAllResults();
    }

    //get membership transactions users count
    public function getMembershipTransactionsCountUsers($userId)
    {
        $this->filterTransactions($userId);
        return $this->builderMembershipTransactionsUsers->countAllResults();
    }

    //get paginated membership transactions
    public function getMembershipTransactionsPaginated($userId, $perPage, $offset)
    {
        $this->filterTransactions($userId);
        return $this->builderMembershipTransactions->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get paginated membership transactions users
    public function getMembershipTransactionsPaginatedUsers($userId, $perPage, $offset)
    {
        $this->filterTransactionsUsers($userId);
        return $this->builderMembershipTransactionsUsers->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter membership transactions
    public function filterTransactions($userId)
    {
        $this->builderMembershipTransactions->join('users', 'users.id = membership_transactions.user_id')->select('membership_transactions.*');
        if (!empty($userId)) {
            $this->builderMembershipTransactions->where('user_id', clrNum($userId));
        }
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builderMembershipTransactions->groupStart()->like('users.username', $q)->orLike('membership_transactions.plan_title', $q)->orLike('membership_transactions.payment_method', $q)->orLike('membership_transactions.payment_id', $q)
                ->orLike('membership_transactions.payment_amount', $q)->orLike('membership_transactions.currency', $q)->orLike('membership_transactions.payment_status', $q)->orLike('membership_transactions.ip_address', $q)->groupEnd();
        }
    }

    //filter membership filterTransactionsUsers
    public function filterTransactionsUsers($userId)
    {
        $this->builderMembershipTransactionsUsers->join('users', 'users.id = membership_transactions_users_subs.user_id')->select('membership_transactions_users_subs.*');
        if (!empty($userId)) {
            $this->builderMembershipTransactionsUsers->where('user_id', clrNum($userId));
        }
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builderMembershipTransactionsUsers->groupStart()->like('users.username', $q)->orLike('membership_transactions_users_subs.plan_title', $q)->orLike('membership_transactions_users_subs.payment_method', $q)->orLike('membership_transactions_users_subs.payment_id', $q)
                ->orLike('membership_transactions_users_subs.payment_amount', $q)->orLike('membership_transactions_users_subs.currency', $q)->orLike('membership_transactions_users_subs.payment_status', $q)->orLike('membership_transactions_users_subs.ip_address', $q)->groupEnd();
        }
    }

    //approve payment
    public function approveTransactionPayment($id)
    {
        $transaction = $this->getMembershipTransaction($id);
        if (!empty($transaction)) {
            $data = [
                'payment_status' => 'payment_received'
            ];
            $this->builderMembershipTransactions->where('id', $transaction->id)->update($data);
            //update user plan
            $userPlan = $this->builderUsersMembershipPlans->where('user_id', $transaction->user_id)->get()->getRow();
            if (!empty($userPlan)) {
                $data = [
                    'payment_status' => 'payment_received',
                    'plan_status' => 1,
                    'plan_start_date' => date('Y-m-d H:i:s')
                ];
                if ($userPlan->is_unlimited_time == 1) {
                    $data['plan_end_date'] = '';
                } else {
                    $planStartDate = date('Y-m-d');

                    $numberOfYearsString = $userPlan->number_of_days;

                    $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

                    $planEndDate = '';

                    if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
                        if ($numberOfYears == 1) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate));
                        } elseif ($numberOfYears == 2) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
                        }
                    } elseif (date('m', strtotime($planStartDate)) >= 10) {
                        // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
                        $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
                    }

                    // Add the calculated end date
                    $data['plan_start_date'] = $planStartDate;
                    $data['plan_end_date'] = $planEndDate;

                    // Format the end date
                    $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));
                }
                $this->builderUsersMembershipPlans->where('id', $userPlan->id)->update($data);
            }
            return true;
        }
        return false;
    }

    public function approveTransactionPaymentUsers($id)
    {
        $transaction = $this->getMembershipTransactionUsers($id);
        if (!empty($transaction)) {
            $data = [
                'payment_status' => 'payment_received'
            ];
            $this->builderMembershipTransactionsUsers->where('id', $transaction->id)->update($data);
            //update user plan
            $userPlan = $this->builderUsersMembershipPlansSubs->where('user_id', $transaction->user_id)->get()->getRow();
            if (!empty($userPlan)) {
                $data = [
                    'payment_status' => 'payment_received',
                    'plan_status' => 1,
                    'plan_start_date' => date('Y-m-d H:i:s')
                ];
                if ($userPlan->is_unlimited_time == 1) {
                    $data['plan_end_date'] = '';
                } else {
                    $planStartDate = date('Y-m-d');

                    $numberOfYearsString = $userPlan->number_of_days;

                    $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

                    $planEndDate = '';

                    if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
                        if ($numberOfYears == 1) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate));
                        } elseif ($numberOfYears == 2) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
                        }
                    } elseif (date('m', strtotime($planStartDate)) >= 10) {
                        // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
                        $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
                    }

                    // Add the calculated end date
                    $data['plan_start_date'] = $planStartDate;
                    $data['plan_end_date'] = $planEndDate;

                    // Format the end date
                    $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));
                }


                $this->builderUsersMembershipPlansSubs->where('id', $userPlan->id)->update($data);
            }
            return true;
        }
        return false;
    }

    //delete transaction
    public function deleteTransaction($id)
    {
        $transaction = $this->getMembershipTransaction($id);
        if (!empty($transaction)) {
            return $this->builderMembershipTransactions->where('id', $transaction->id)->delete();
        }
        return false;
    }

    //delete transaction
    public function deleteTransactionUsers($id)
    {
        $transaction = $this->getMembershipTransactionUsers($id);
        if (!empty($transaction)) {
            return $this->builderMembershipTransactionsUsers->where('id', $transaction->id)->delete();
        }
        return false;
    }

    //delete plan
    public function deletePlan($id)
    {
        $plan = $this->getPlan($id);
        if (!empty($plan)) {
            return $this->builderMembershipPlans->where('id', $plan->id)->delete();
        }
        return false;
    }

    /*
     * --------------------------------------------------------------------
     * Shop Opening Requests
     * --------------------------------------------------------------------
     */

    //get shop opening requests count
    public function getShopOpeningRequestsCount()
    {
        return $this->builderUsers->where('is_active_shop_request', 1)->countAllResults();
    }

    //get paginated users
    public function getShopOpeningRequestsPaginated($perPage, $offset)
    {
        return $this->builderUsers->where('is_active_shop_request', 1)->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //add shop opening request
    public function addShopOpeningRequest($data)
    {
        if (empty($data['country_id'])) {
            $data['country_id'] = 0;
        }
        if (empty($data['state_id'])) {
            $data['state_id'] = 0;
        }
        if (empty($data['city_id'])) {
            $data['city_id'] = 0;
        }
        return $this->builderUsers->where('id', user()->id)->update($data);
    }

    //approve shop opening request
    public function approveShopOpeningRequest($userId)
    {
        //approve request
        if (inputPost('submit') == 1) {
            $dataShop = [
                'role_id' => 2,
                'is_active_shop_request' => 0,
            ];
            //update user plan
            $userPlan = $this->getUserPlanByUserId($userId);
            if (!empty($userPlan)) {
                $data = [
                    'payment_status' => 'payment_received',
                    'plan_status' => 1,
                    'plan_start_date' => date('Y-m-d H:i:s')
                ];
                if ($userPlan->is_unlimited_time == 1) {
                    $data['plan_end_date'] = '';
                } else {
                    $planStartDate = date('Y-m-d');
                    $planEndDate = '';

                    $planStartDate = date('Y-m-d');

                    $numberOfYearsString = $userPlan->number_of_days;

                    $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

                    $planEndDate = '';

                    if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
                        if ($numberOfYears == 1) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate));
                        } elseif ($numberOfYears == 2) {
                            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
                        }
                    } elseif (date('m', strtotime($planStartDate)) >= 10) {
                        // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
                        $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
                    }

                    // Add the calculated end date
                    $data['plan_start_date'] = $planStartDate;
                    $data['plan_end_date'] = $planEndDate;

                    // Format the end date
                    $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));
                }
                $this->builderUsersMembershipPlans->where('id', $userPlan->id)->update($data);
            }
        } else {
            //decline request
            $dataShop = [
                'is_active_shop_request' => 2,
            ];
        }
        return $this->builderUsers->where('id', clrNum($userId))->update($dataShop);
    }

    /*
     * --------------------------------------------------------------------
     * Roles & Permissions
     * --------------------------------------------------------------------
     */

    //add role
    public function addRole()
    {
        $nameArray = array();
        $permissionsArray = array();
        foreach ($this->activeLanguages as $language) {
            $item = [
                'lang_id' => $language->id,
                'name' => inputPost('role_name_' . $language->id, true)
            ];
            array_push($nameArray, $item);
        }
        $permissions = inputPost('permissions');
        $pushAdminPanel = false;
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                array_push($permissionsArray, $permission);
                if ($permission != 2) {
                    $pushAdminPanel = true;
                }
            }
        }
        if ($pushAdminPanel && !in_array(1, $permissions)) {
            array_push($permissionsArray, 1);
        }
        $permissionsStr = implode(',', $permissionsArray);
        $data = [
            'role_name' => serialize($nameArray),
            'permissions' => $permissionsStr,
            'is_default' => 0,
            'is_super_admin' => 0,
            'is_admin' => 0,
            'is_vendor' => 0,
            'is_member' => 0
        ];
        if (!empty($permissions) && in_array(1, $permissions)) {
            $data['is_admin'] = 1;
        }
        if (!empty($permissions) && in_array(2, $permissions)) {
            $data['is_vendor'] = 1;
        }
        if (empty($permissions)) {
            $data['is_member'] = 1;
        }
        return $this->builderRoles->insert($data);
    }

    //edit role
    public function editRole($id)
    {
        $role = $this->getRole($id);
        if (!empty($role)) {
            $nameArray = array();
            $permissionsArray = array();
            foreach ($this->activeLanguages as $language) {
                $item = [
                    'lang_id' => $language->id,
                    'name' => inputPost('role_name_' . $language->id)
                ];
                array_push($nameArray, $item);
            }

            $data = ['role_name' => serialize($nameArray)];
            if ($role->is_default != 1) {
                $permissions = inputPost('permissions');
                $pushAdminPanel = false;
                if (!empty($permissions)) {
                    foreach ($permissions as $permission) {
                        array_push($permissionsArray, $permission);
                        if ($permission != 2) {
                            $pushAdminPanel = true;
                        }
                    }
                }
                if ($pushAdminPanel && !in_array(1, $permissions)) {
                    array_push($permissionsArray, 1);
                }
                $permissionsStr = implode(',', $permissionsArray);
                $data['permissions'] = $permissionsStr;
                $data['is_admin'] = 0;
                $data['is_vendor'] = 0;
                if (!empty($permissions) && in_array(1, $permissions)) {
                    $data['is_admin'] = 1;
                    $data['is_member'] = 0;
                }
                if (!empty($permissions) && in_array(2, $permissions)) {
                    $data['is_vendor'] = 1;
                    $data['is_member'] = 0;
                }
                if (empty($permissions)) {
                    $data['is_member'] = 1;
                }
            }
            return $this->builderRoles->where('id', $role->id)->update($data);
        }
        return false;
    }

    //get role
    public function getRole($id)
    {
        return $this->builderRoles->where('id', clrNum($id))->get()->getRow();
    }

    //get roles
    public function getRoles()
    {
        return $this->builderRoles->orderBy('id')->get()->getResult();
    }

    //change user role
    public function changeUserRole($userId, $roleId)
    {
        $user = getUser($userId);
        if (!empty($user)) {
            $role = $this->getRole($roleId);
            if (!empty($role)) {
                return $this->builderUsers->where('id', $user->id)->update(['role_id' => $role->id]);
            }
        }
        return false;
    }

    //delete role
    public function deleteRole($id)
    {
        $role = $this->getRole($id);
        if (!empty($role)) {
            $users = $this->builderUsers->where('role_id', $role->id)->get()->getResult();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $this->builderUsers->where('id', $user->id)->update(['role_id' => 3]);
                }
            }
            return $this->builderRoles->where('id', $role->id)->delete();
        }
        return false;
    }

    //custom added
    public function getAllUsersMembers()
    {
        $this->builderUsers->orderBy('first_name', 'asc');
        return $this->builderUsers->get()->getResultArray();
    }


    //prepare data
    public function preparePlanDataUsers()
    {
        $data = [
            'number_of_days' => inputPost('number_of_days'),
            'price' => inputPost('price'),
            'title' => inputPost('title'),
        ];

        $arrayFeatures = array();
        foreach ($this->activeLanguages as $language) {
            //add features
            $features = inputPost('feature_' . $language->id);
            $array = array();
            if (!empty($features)) {
                foreach ($features as $feature) {
                    $feature = trim($feature ?? '');
                    if (!empty($feature)) {
                        array_push($array, $feature);
                    }
                }
            }
            $itemFeature = [
                'lang_id' => $language->id,
                'features' => $array
            ];
            array_push($arrayFeatures, $itemFeature);
        }

        $data['price'] = getPrice($data['price'], 'database');
        if (empty($data['price'])) {
            $data['price'] = 0;
        }

        $data['features'] = serialize($arrayFeatures);

        if (empty($data['number_of_days'])) {
            $data['number_of_days'] = 0;
        }

        return $data;
    }

    //add plan
    public function addPlanUsers()
    {
        $data = $this->preparePlanDataUsers();

        $uploadModel = new UploadModel();
        $eventImage = $uploadModel->uploadMembershipImage('memImage');

        if (!empty($eventImage) && !empty($eventImage['path'])) {
            //deleteFile($this->generalSettings->event_image);
            $data['imageUrl'] = $eventImage['path'];
        }

        //echo "<pre>";print_r($data);die;
        return $this->builderMembershipPlansUsers->insert($data);
    }

    //get plans
    public function getPlansUsers()
    {
        return $this->builderMembershipPlansUsers->orderBy('id')->where('deleted', 0)->get()->getResult();
    }

    //get plan
    public function getPlanUsers($id)
    {
        return $this->builderMembershipPlansUsers->where('id', clrNum($id))->get()->getRow();
    }

    //edit plan
    public function editPlanUsers($id)
    {
        $plan = $this->getPlanUsers($id);

        $uploadModel = new UploadModel();
        $eventImage = $uploadModel->uploadMembershipImage('memImage');


        if (!empty($plan)) {
            $data = $this->preparePlanDataUsers();
            if (!empty($eventImage) && !empty($eventImage['path'])) {
                //deleteFile($this->generalSettings->event_image);
                $data['imageUrl'] = $eventImage['path'];
            }
            return $this->builderMembershipPlansUsers->where('id', $plan->id)->update($data);
        }
        return false;
    }

    //delete plan
    public function deletePlanUsers($id)
    {
        $plan = $this->getPlanUsers($id);
        $data = ['deleted' => '1'];
        if (!empty($plan)) {
            return $this->builderMembershipPlansUsers->where('id', $plan->id)->update($data);
        }
        return false;
    }

    //add user plan
    public function addUserPlanSubs($dataTransaction, $plan, $userId)
    {
        $oldPlan = $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->update(['deleted' => 1]);
        }
        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $plan->title,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->paymentSettings->default_currency,
            'payment_method' => $dataTransaction['payment_method'],
            'payment_status' => $dataTransaction['payment_status'],
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d')
        ];

        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        // Add the calculated end date
        $data['plan_start_date'] = $planStartDate;
        $data['plan_end_date'] = $planEndDate;

        // Format the end date
        $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));

        if ($dataTransaction["payment_status"] == 'awaiting_payment') {
            $data['plan_status'] = 0;
        }

        $data['user_id'] = clrNum($userId);
        $this->builderUsersMembershipPlansSubs->insert($data);

        //update user plan status
        $this->builderUsers->where('id', clrNum($userId))->update(['is_membership_plan_expired_subs' => 0]);
    }

    //add user plan migration
    public function addUserPlanSubsMigration($planData, $userId)
    {
        $oldPlan = $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->update(['deleted' => 1]);
        }

        $data = [
            'plan_id' => $planData['plan_id'],
            'plan_title' => $planData['plan_title'],
            'number_of_days' => $planData['number_of_days'],
            'price' => $planData['price'],
            'currency' => $this->paymentSettings->default_currency,
            'payment_method' => 'Migration',
            'payment_status' => 'Success',
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d', strtotime($planData['plan_start_date'])),
            'plan_end_date' => date('Y-m-d', strtotime($planData['plan_end_date'])),
            'user_id' => $planData['user_id'],
        ];

        $success = $this->builderUsersMembershipPlansSubs->insert($data);

        //update user plan status
        $this->builderUsers->where('id', clrNum($userId))->update(['is_membership_plan_expired_subs' => 0]);

        if ($success) {
            return true;
        }

        return false;
    }

    public function addMembershipTransactionUsers($dataTransaction, $plan)
    {
        $data = [
            'payment_method' => $dataTransaction['payment_method'],
            'payment_id' => $dataTransaction['payment_id'],
            'user_id' => user()->id,
            'plan_id' => $plan->id,
            'plan_title' => $plan->title,
            'payment_amount' => $dataTransaction['payment_amount'],
            'currency' => $dataTransaction['currency'],
            'payment_status' => $dataTransaction['payment_status'],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        $data['plan_expiry_date'] = $planEndDate;

        $data['plan_expiry_date'] = date('Y-m-d H:i:s', strtotime($data['plan_expiry_date']));


        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->builderMembershipTransactionsUsers->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());
        }
    }

    //get membership transaction
    public function getMembershipTransactionUsers($id)
    {
        return $this->builderMembershipTransactionsUsers->where('id', clrNum($id))->get()->getRow();
    }

    public function getAllBoardOfMembers()
    {
        return $this->builderBoardDirectors->where('delete', 0)
            ->orderBy('order', 'ASC')
            ->get()->getResult();
    }
    public function getAllBoardOfMembersSub()
    {
        return $this->builderBoardDirectorsSub->where('delete', 0)
            ->orderBy('order', 'ASC')
            ->get()->getResult();
    }

    public function contactUsFormPost()
    {
        $data = array(
            'name' => inputPost('name'),
            'email' => inputPost('email'),
            'phone' => inputPost('phone'),
            'subject' => inputPost('subject'),
            'message' => inputPost('message'),
        );
        return $this->builderContactUsForm->insert($data);
    }

    public function sponsorshipEnquiryPost()
    {
        $data = array(
            'first_name' => inputPost('first_name'),
            'last_name' => inputPost('last_name'),
            'business_email' => inputPost('email'),
            'phone_number' => inputPost('phone_number'),
            'company' => inputPost('company'),
            'message' => inputPost('message'),
        );
        return $this->builderSponsorshipEnquiry->insert($data);
    }

    public function getAllOurSponsors()
    {
        return $this->builderOurSponsorsList->where('delete', 0)
            ->orderBy('order', 'ASC')
            ->get()->getResult();
    }

    public function getPlansUsersLoggedIn()
    {
        return $this->builderUsersMembershipPlansSubs->where('user_id', user()->id)->where('deleted', 0)->where('plan_status', 1)->get()->getRow();
    }

    public function msgUserSentExpiry($id, $user)
    {
        return $this->builderUsersMembershipPlansSubs->where('id', $id)->where('user_id', $user)->where('deleted', 0)->where('plan_status', 1)->get()->getRow();
    }
    public function msgUserSentExpiryPost($id, $user)
    {
        return $this->builderUsersMembershipPlansSubs->where('id', $id)->where('user_id', $user)->where('deleted', 1)->where('plan_status', 0)->get()->getRow();
    }

    public function msgUserSentExpirybm($id, $user)
    {
        return $this->builderUsersMembershipPlans->where('id', $id)->where('user_id', $user)->where('plan_status', 1)->get()->getRow();
    }

    public function msgUserSentExpiryToday($id, $user)
    {
        $today_date = formatDate(date('Y-m-d'));
        $data = array('msgSentDate' => $today_date);
        return $this->builderUsersMembershipPlansSubs->where('id', $id)->where('user_id', $user)->where('deleted', 0)->where('plan_status', 1)->update($data);
    }

    public function msgUserSentExpiryTodaybm($id, $user)
    {
        $today_date = formatDate(date('Y-m-d'));
        $data = array('msgSentDate' => $today_date);
        return $this->builderUsersMembershipPlans->where('id', $id)->where('user_id', $user)->where('plan_status', 1)->update($data);
    }

    public function updatePlansDetailsDeleted($userId, $plan_id)
    {
        $data = array
        (
            'plan_status' => 0,
            'deleted' => 1,
        );
        return $this->builderUsersMembershipPlansSubs->where('plan_id', $plan_id)->where('user_id', $userId)->where('deleted', 0)->where('plan_status', 1)->update($data);
    }

    public function getMemberInvoice()
    {
        $data = $this->builderMembershipTransactionsUsers->select('membership_transactions_users_subs.id,plan_title,membership_transactions_users_subs.created_at,payment_id,payment_method, payment_status,payment_amount')
            ->join('users', 'users.id =membership_transactions_users_subs.user_id')
            ->where('user_id', $this->session->mds_ses_id)
            ->orderBy('membership_transactions_users_subs.id', 'desc')
            ->get()->getResultArray();

        return $data;
    }

    public function updateEpaymentMembershipUsers($plan, $userId)
    {
        $randomNumber = rand(100000, 999999);

        $oldPlan = $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->update(['deleted' => 1]);
        }
        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $plan->title,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->paymentSettings->default_currency,
            'payment_method' => 'E-Payment',
            'payment_status' => 'Pending',
            'plan_status' => 0,
            'is_epayment' => 1,
            'random_ref_no' => $randomNumber,
            'plan_start_date' => date('Y-m-d')
        ];

        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        // Add the calculated end date
        $data['plan_start_date'] = $planStartDate;
        $data['plan_end_date'] = $planEndDate;

        // Format the end date
        $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));

        $data['user_id'] = clrNum($userId);
        return $this->builderUsersMembershipPlansSubs->insert($data);


    }

    public function getEpaymentMembershipUsers()
    {
        $data = $this->builderUsersMembershipPlansSubs->select('user_id,plan_id,plan_title,number_of_days,price,random_ref_no,username,email,phone_number,plan_start_date')
            ->join('users', 'users.id = users_membership_plans_subs.user_id')
            ->where('is_epayment', 1)
            ->where('payment_method', 'E-Payment')
            ->get()->getResult();

        return $data;
    }

    public function getEpaymentDataMembershipUsers($id)
    {
        $data = $this->builderUsersMembershipPlansSubs->select('user_id,plan_id,plan_title,number_of_days,price,random_ref_no,username,email,phone_number,plan_start_date')
            ->join('users', 'users.id = users_membership_plans_subs.user_id')
            ->where('random_ref_no', $id)
            ->where('is_epayment', 1)
            ->get()->getRow();

        return $data;
    }

    public function updateEpaymentApproveMembershipUsers()
    {
        $data = [
            'payment_method' => inputPost('paymentMethod'),
            'payment_id' => inputPost('transId'),
            'user_id' => inputPost('user_id'),
            'plan_id' => inputPost('plan_id'),
            'plan_title' => inputPost('plan_title'),
            'payment_amount' => inputPost('totalRec'),
            'currency' => 'CAD',
            'payment_status' => inputPost('paymentStatus'),
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $plan = $this->getPlanUsers(inputPost('plan_id'));
        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        $data['plan_expiry_date'] = $planEndDate;

        $data['plan_expiry_date'] = date('Y-m-d H:i:s', strtotime($data['plan_expiry_date']));


        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->builderMembershipTransactionsUsers->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());
            $randomno = inputPost('random_ref_no');
            $updateData = array(
                'plan_status' => 1,
                'payment_status' => inputPost('paymentStatus'),
                'is_epayment' => 0,
                'plan_start_date' => $planStartDate,
                'plan_end_date' => $planEndDate,
            );

            $this->builderUsersMembershipPlansSubs->where('random_ref_no', $randomno)->where('plan_id', inputPost('plan_id'))->where('user_id', inputPost('user_id'))->update($updateData);

            return $this->builderUsers->where('id', inputPost('user_id'))->update(['is_membership_plan_expired_subs' => 0]);
        }
    }

    public function getMemberShipInvoiceDataUsers($id)
    {
        $data = $this->builderMembershipTransactionsUsers->select('membership_transactions_users_subs.id,user_id,plan_id,plan_title,payment_method,payment_id,payment_amount,payment_status,currency,plan_expiry_date,membership_transactions_users_subs.created_at,username,phone_number,email')
            ->join('users', 'users.id =membership_transactions_users_subs.user_id')
            ->where('membership_transactions_users_subs.id', $id)
            ->get()->getRow();

        return $data;
    }

    public function rejectEpaymentApprovalMembershipUsers($random_ref_no)
    {
        $refData = $this->builderUsersMembershipPlansSubs->select('user_id,username,phone_number,email,plan_id')
            ->join('users', 'users.id = users_membership_plans_subs.user_id')
            ->where('random_ref_no', $random_ref_no)
            ->get()->getRow();

        $data = array(
            'is_epayment' => -1,
            'deleted' => 1,
            'payment_status' => 'Rejected',
        );

        $status = $this->builderUsersMembershipPlansSubs->where('random_ref_no', $random_ref_no)->where('user_id', $refData->user_id)->where('plan_id', $refData->plan_id)->update($data);

        if ($status) {
            $emailData =
                [
                    'email_type' => 'activation',
                    'email_address' => $refData->email,
                    'email_data' => serialize([
                        'content' => 'Name : ' . $refData->username,
                        'content_1' => 'Phone : ' . $refData->phone_number,
                        'content_2' => 'Payment Method : E-transfer Payment',
                        'content_3' => 'Status : Failed',
                        'content_4' => 'We regret to inform you that we have not received payment for your memberhip plan, and as a result, your membership has been canceled.',
                    ]),
                    'email_priority' => 1,
                    'email_subject' => 'Membership Payment Failed',
                    'template_path' => 'email/rsvp_payment'
                ];

            addToEmailQueue($emailData);
            return true;
        } else {
            return false;
        }
    }

    public function updateEpaymentMembership($plan, $userId)
    {
        $randomNumber = rand(100000, 999999);

        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'number_of_ads' => $plan->number_of_ads,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->paymentSettings->default_currency,
            'is_free' => $plan->is_free,
            'is_unlimited_number_of_ads' => $plan->is_unlimited_number_of_ads,
            'is_unlimited_time' => $plan->is_unlimited_time,
            'payment_method' => 'E-Payment',
            'payment_status' => 'Pending',
            'plan_status' => 0,
            'is_epayment' => 1,
            'random_ref_no' => $randomNumber,
            'plan_start_date' => date('Y-m-d')
        ];

        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        // Add the calculated end date
        $data['plan_start_date'] = $planStartDate;
        $data['plan_end_date'] = $planEndDate;

        // Format the end date
        $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));

        $data['user_id'] = clrNum($userId);
        return $this->builderUsersMembershipPlans->insert($data);
    }

    public function getEpaymentMembership()
    {
        $data = $this->builderUsersMembershipPlans->select('user_id,plan_id,plan_title,number_of_days,price,random_ref_no,username,email,phone_number,plan_start_date')
            ->join('users', 'users.id = users_membership_plans.user_id')
            ->where('is_epayment', 1)
            ->where('payment_method', 'E-Payment')
            ->get()->getResult();

        return $data;
    }

    public function getEpaymentDataMembership($id)
    {
        $data = $this->builderUsersMembershipPlans->select('user_id,plan_id,plan_title,number_of_days,price,random_ref_no,username,email,phone_number,plan_start_date')
            ->join('users', 'users.id = users_membership_plans.user_id')
            ->where('random_ref_no', $id)
            ->where('is_epayment', 1)
            ->get()->getRow();

        return $data;
    }

    public function updateEpaymentApproveMembership()
    {
        $planId = inputPost('plan_id');

        $plan = $this->getPlan($planId);

        $price = getPrice(inputPost('totalRec'), 'database');

        $data = [
            'payment_method' => inputPost('paymentMethod'),
            'payment_id' => inputPost('transId'),
            'user_id' => inputPost('user_id'),
            'plan_id' => $planId,
            'plan_title' => $this->getMembershipPlanTitle($plan),
            'payment_amount' => $price,
            'currency' => 'CAD',
            'payment_status' => inputPost('paymentStatus'),
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $planStartDate = date('Y-m-d');
        $planEndDate = '';

        $planStartDate = date('Y-m-d');

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        $data['plan_expiry_date'] = $planEndDate;

        $data['plan_expiry_date'] = date('Y-m-d H:i:s', strtotime($data['plan_expiry_date']));


        $ip = getIPAddress();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->builderMembershipTransactions->insert($data)) {
            helperSetSession('mds_membership_transaction_insert_id', $this->db->insertID());

            if (!isVendor()) {
                $this->builderUsers->where('id', inputPost('user_id'))->update(['is_active_shop_request' => 1]);
            }

            $randomno = inputPost('random_ref_no');
            $updateData = array(
                'plan_status' => 1,
                'payment_status' => inputPost('paymentStatus'),
                'is_epayment' => 0,
                'plan_start_date' => $planStartDate,
                'plan_end_date' => $planEndDate,
            );

            $this->builderUsersMembershipPlans->where('random_ref_no', $randomno)->where('plan_id', inputPost('plan_id'))->where('user_id', inputPost('user_id'))->update($updateData);

            return $this->builderUsers->where('id', inputPost('user_id'))->update(['is_membership_plan_expired' => 0]);
        }
    }

    public function getMemberShipInvoiceData($id)
    {
        $data = $this->builderMembershipTransactions->select('membership_transactions.id,user_id,plan_id,plan_title,payment_method,payment_id,payment_amount,payment_status,currency,plan_expiry_date,membership_transactions.created_at,username,phone_number,email')
            ->join('users', 'users.id =membership_transactions.user_id')
            ->where('membership_transactions.id', $id)
            ->get()->getRow();

        return $data;
    }

    public function rejectEpaymentApprovalMembership($random_ref_no)
    {
        $refData = $this->builderUsersMembershipPlans->select('user_id,username,phone_number,email,plan_id')
            ->join('users', 'users.id = users_membership_plans.user_id')
            ->where('random_ref_no', $random_ref_no)
            ->get()->getRow();

        $data = array(
            'is_epayment' => -1,
            'payment_status' => 'Rejected',
        );

        $status = $this->builderUsersMembershipPlans->where('random_ref_no', $random_ref_no)->where('user_id', $refData->user_id)->where('plan_id', $refData->plan_id)->update($data);

        if ($status) {
            $emailData =
                [
                    'email_type' => 'activation',
                    'email_address' => $refData->email,
                    'email_data' => serialize([
                        'content' => 'Name : ' . $refData->username,
                        'content_1' => 'Phone : ' . $refData->phone_number,
                        'content_2' => 'Payment Method : E-transfer Payment',
                        'content_3' => 'Status : Failed',
                        'content_4' => 'We regret to inform you that we have not received payment for your business memberhip plan, and as a result, your business membership has been canceled.',
                    ]),
                    'email_priority' => 1,
                    'email_subject' => 'Business Membership Payment Failed',
                    'template_path' => 'email/rsvp_payment'
                ];

            addToEmailQueue($emailData);
            return $this->builderUsers->where('id', $refData->user_id)->update(['is_membership_plan_expired' => 1]);
        } else {
            return false;
        }
    }

    //get plan by title
    public function getPlanByTitle($title)
    {
        return $this->builderMembershipPlansUsers->where('membership_plans_users.title', removeSpecialCharacters($title))->get()->getRow();
    }

    //get plan by title
    public function getPlanByTitleDuration($title, $duration)
    {
        return $this->builderMembershipPlansUsers->where('membership_plans_users.title', removeSpecialCharacters($title))->where('membership_plans_users.number_of_days', removeSpecialCharacters($duration))->get()->getRow();
    }

    public function addMembershipPlanManually()
    {
        $plan_id_get = inputPost('plan_id');
        $userId = inputPost('user_id');
        $comment = inputPost('comment');
        $planStartD = inputPost('plan_start_date');
        $plan = $this->getPlanUsers($plan_id_get);

        $oldPlan = $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->get()->getRow();
        if (!empty($oldPlan)) {
            $this->builderUsersMembershipPlansSubs->where('user_id', clrNum($userId))->update(['deleted' => 1]);
        }
        $data = [
            'plan_id' => $plan->id,
            'plan_title' => $plan->title,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->paymentSettings->default_currency,
            'payment_method' => 'Manually',
            'payment_status' => $comment,
            'plan_status' => 1,
            'plan_start_date' => $planStartD
        ];

        $planStartDate = $planStartD;

        $numberOfYearsString = $plan->number_of_days;

        $numberOfYears = (int) explode(' ', $numberOfYearsString)[0];

        $planEndDate = '';

        if (date('m', strtotime($planStartDate)) >= 1 && date('m', strtotime($planStartDate)) <= 10) {
            if ($numberOfYears == 1) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate));
            } elseif ($numberOfYears == 2) {
                $planEndDate = date('Y-12-31', strtotime($planStartDate . " + 1 years"));
            }
        } elseif (date('m', strtotime($planStartDate)) >= 10) {
            // If purchased in October, November or December, expiry date is December of the next year (with a grace month)
            $planEndDate = date('Y-12-31', strtotime($planStartDate . " + $numberOfYears years"));
        }

        // Add the calculated end date
        $data['plan_start_date'] = $planStartDate;
        $data['plan_end_date'] = $planEndDate;

        // Format the end date
        $data['plan_end_date'] = date('Y-m-d', strtotime($data['plan_end_date']));

        $data['user_id'] = clrNum($userId);
        $success = $this->builderUsersMembershipPlansSubs->insert($data);

        //update user plan status
        $this->builderUsers->where('id', clrNum($userId))->update(['is_membership_plan_expired_subs' => 0]);

        if ($success) {
            return true;
        }

        return false;
    }

    public function getPlansUsersManually($id)
    {
        return $this->builderUsersMembershipPlansSubs->where('user_id', $id)->where('deleted', 0)->where('plan_status', 1)->where('payment_method', 'Manually')->orderBy('id', 'desc')->limit(1)->get()->getRow();
    }

    public function deleteUser($id)
    {
        $user_value = $this->builderUsers->where('id', $id)->get()->getResultArray();
        $user = $user_value[0];
        if (!empty($user)) {
            $data = [
                'member_id' => $user['id'],
                'username' => $user['username'],
                'slug' => $user['slug'],
                'email' => $user['email'],
                'email_status' => $user['email_status'],
                'token' => $user['token'],
                'password' => $user['password'],
                'role_id' => $user['role_id'],
                'balance' => $user['balance'],
                'number_of_sales' => $user['number_of_sales'],
                'user_type' => $user['user_type'],
                'facebook_id' => $user['facebook_id'],
                'google_id' => $user['google_id'],
                'vkontakte_id' => $user['vkontakte_id'],
                'avatar' => $user['avatar'],
                'cover_image' => $user['cover_image'],
                'cover_image_type' => $user['cover_image_type'],
                'banned' => $user['banned'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'about_me' => $user['about_me'],
                'phone_number' => $user['phone_number'],
                'country_id' => $user['country_id'],
                'state_id' => $user['state_id'],
                'city_id' => $user['city_id'],
                'address' => $user['address'],
                'zip_code' => $user['zip_code'],
                'show_email' => $user['show_email'],
                'show_phone' => $user['show_phone'],
                'show_location' => $user['show_location'],
                'personal_website_url' => $user['personal_website_url'],
                'facebook_url' => $user['facebook_url'],
                'twitter_url' => $user['twitter_url'],
                'instagram_url' => $user['instagram_url'],
                'pinterest_url' => $user['pinterest_url'],
                'linkedin_url' => $user['linkedin_url'],
                'vk_url' => $user['vk_url'],
                'youtube_url' => $user['youtube_url'],
                'whatsapp_url' => $user['whatsapp_url'],
                'telegram_url' => $user['telegram_url'],
                'last_seen' => $user['last_seen'],
                'show_rss_feeds' => $user['show_rss_feeds'],
                'send_email_new_message' => $user['send_email_new_message'],
                'is_active_shop_request' => $user['is_active_shop_request'],
                'vendor_documents' => $user['vendor_documents'],
                'is_membership_plan_expired' => $user['is_membership_plan_expired'],
                'is_membership_plan_expired_subs' => $user['is_membership_plan_expired_subs'],
                'is_used_free_plan' => $user['is_used_free_plan'],
                'cash_on_delivery' => $user['cash_on_delivery'],
                'created_at' => $user['created_at'],
                'areas_of_interest' => $user['areas_of_interest'],
                'members_in_family' => $user['members_in_family'],
                'show_profile' => $user['show_profile'],
                'two_factor' => $user['two_factor'],
                'secondary_email' => $user['secondary_email'],
                'secondary_password' => $user['secondary_password']
            ];

            $inserted = $this->builderUsersDelete->insert($data);
            if ($inserted) {
                return $this->builderUsers->where('id', $id)->delete();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>