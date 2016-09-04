<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Syscover\Comunik\Libraries\ComunikLibrary;
use Syscover\Comunik\Models\Contact;
use Syscover\Crm\Libraries\CrmLibrary;
use Syscover\Crm\Models\Customer;
use Syscover\Crm\Models\Group;
use Syscover\Market\Models\GroupCustomerClassTax;
use Syscover\Market\Models\Product;
use Syscover\Market\Models\TaxRule;
use Syscover\Pulsar\Models\Package;
use Syscover\ShoppingCart\Cart;
use Syscover\ShoppingCart\CartItemTaxRules;
use Syscover\ShoppingCart\Facades\CartProvider;

/**
 * Class CustomerFrontendController
 * @package App\Http\Controllers
 */

class CustomerFrontendController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Route to get login form
     *
     * @var string
     */
    protected $loginPath;

    /**
     * Redirect route after logout
     *
     * @var string
     */
    protected $logoutPath;

    /**
     * Here you can customize your guard, this guar has to set in auth.php config
     *
     * @var string
     */
    protected $guard;


    public function __construct()
    {
        $this->redirectTo   = route('account-' . user_lang());
        $this->loginPath    = route('getLogin-' . user_lang());
        $this->logoutPath   = route('home-' . user_lang());
    }

    /**
     * Show account view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account(Request $request)
    {
        $response['groups']     = Group::builder()->get();
        $response['customer']   = auth('crm')->user();

        return view('www.content.account', $response);
    }

    /**
     * Show login view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $response = [];
        return view('www.content.login', $response);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'user'      => 'required',
            'password'  => 'required',
        ]);

        $credentials = [
            'user_301'  => $request->input('user'),
            'password'  => $request->input('password')
        ];

        if(auth('crm')->attempt($credentials, $request->has('remember')))
        {
            // check if customer is active
            if(! auth('crm')->user()->active_301)
            {
                auth('crm')->logout();

                // error user inactive
                if($request->input('responseType') == 'json')
                {
                    return response()->json([
                        'status'    => 'error',
                        'message'   => 'User inactive'
                    ]);
                }
                else
                {
                    return redirect($this->loginPath)->withErrors([
                        'message'   => 'User inactive'
                    ])->withInput();
                }
            }

            // set customer class tax if market package is installed
            // necessary if you have installed market package
            $marketPackage = Package::builder()->find(12);
            if($marketPackage != null && $marketPackage->active_012 == true)
            {
                $groupCustomerClassTax = GroupCustomerClassTax::builder()->where('group_id_102', auth('crm')->user()->group_id_301)->first();

                if($groupCustomerClassTax != null)
                    auth('crm')->user()->classTax = $groupCustomerClassTax->id_100;
            }

            // authentication OK!
            // reload ShoppingCart with new tax rules
            if(CartProvider::instance()->getCartItems()->count() > 0)
            {
                $cartProducts = Product::builder()
                    ->whereIn('id_111', CartProvider::instance()->getCartItems()->pluck('id'))
                    ->get();

                $taxRules = TaxRule::builder()
                    ->where('country_id_103', empty(auth('crm')->user()->country_id_301)? config('market.taxCountry') : auth('crm')->user()->country_id_301)
                    ->where('customer_class_tax_id_106', empty(auth('crm')->user()->classTax)? config('market.taxCustomerClass') : auth('crm')->user()->classTax)
                    ->whereIn('product_class_tax_id_107', $cartProducts->pluck('product_class_tax_id_111')->toArray())
                    ->orderBy('priority_104', 'asc')
                    ->get();

                $taxRules = $taxRules->groupBy('product_class_tax_id_107')
                    ->map(function($taxRule, $key){
                        return $taxRule->sortBy('priority_104');
                    });

                foreach (CartProvider::instance()->getCartItems() as $item)
                {
                    // reset tax rules from item
                    $item->taxRules = new CartItemTaxRules();

                    // if there ara any tax rule, and product with tax rule
                    if(
                        $taxRules->count() > 0 &&
                        $cartProducts->where('id_111', $item->id)->count() > 0 &&
                        is_array($taxRules->get($cartProducts->where('id_111', $item->id)->first()->product_class_tax_id_111)) &&
                        $taxRules->get($cartProducts->where('id_111', $item->id)->first()->product_class_tax_id_111)->count() > 0
                    )
                    {
                        // get tax rules from item
                        $itemTaxRules = $taxRules->get($cartProducts->where('id_111',$item->id)->first()->product_class_tax_id_111);

                        // add tax rules to item
                        foreach ($itemTaxRules as $itemTaxRule)
                        {
                            $item->addTaxRule($itemTaxRule->getTaxRuleShoppingCart());
                        }
                    }
                    // force to calculate amounts
                    $item->calculateAmounts(Cart::PRICE_WITHOUT_TAX);
                }
            }

            // response
            if($request->input('responseType') == 'json')
            {
                return response()->json([
                    'status'    => 'success',
                    'customer'  => auth('crm')->user()
                ]);
            }
            else
            {
                return redirect()->intended($this->redirectTo);
            }
        }

        // error authentication
        if($request->input('responseType') == 'json')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User or password incorrect'
            ]);
        }
        else
        {
            return redirect($this->loginPath)->withErrors([
                'message' => 'User or password incorrect'
            ])->withInput();
        }
    }

    /**
     * Logout user and load default tax rules.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth('crm')->logout();

        // reload Shopping cart with default tax rules
        if(CartProvider::instance()->getCartItems()->count() > 0)
        {
            $cartProducts = Product::builder()
                ->whereIn('id_111', CartProvider::instance()->getCartItems()->pluck('id'))
                ->get();

            // get default taxes
            $taxRules = TaxRule::builder()
                ->where('country_id_103', env('TAX_COUNTRY'))
                ->where('customer_class_tax_id_106', env('TAX_CUSTOMER_CLASS'))
                ->whereIn('product_class_tax_id_107', $cartProducts->pluck('product_class_tax_id_111')->toArray())
                ->orderBy('priority_104', 'asc')
                ->get();

            $taxRules = $taxRules->groupBy('product_class_tax_id_107')
                ->map(function($taxRule, $key){
                    return $taxRule->sortBy('priority_104');
                });

            foreach (CartProvider::instance()->getCartItems() as $item)
            {
                // reset tax rules from item
                $item->resetTaxRules();

                // if there ara any tax rule, and product with tax rule
                if(
                    $taxRules->count() > 0 &&
                    $cartProducts->where('id_111', $item->id)->count() > 0 &&
                    is_array($taxRules->get($cartProducts->where('id_111', $item->id)->first()->product_class_tax_id_111)) &&
                    $taxRules->get($cartProducts->where('id_111', $item->id)->first()->product_class_tax_id_111)->count() > 0
                )
                {
                    // get tax rules from item
                    $itemTaxRules = $taxRules->get($cartProducts->where('id_111',$item->id)->first()->product_class_tax_id_111);

                    // add tax rules to item
                    foreach ($itemTaxRules as $itemTaxRule)
                    {
                        $item->addTaxRule($itemTaxRule->getTaxRuleShoppingCart());
                    }
                }
                // force to calculate amounts
                $item->calculateAmounts(Cart::PRICE_WITHOUT_TAX);
            }
        }

        return redirect($this->logoutPath);
    }

    /**
     * Show sing in view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSingIn()
    {
        // get customer groups
        $response['groups'] = Group::builder()->get();

        return view('www.content.sing_in', $response);
    }

    /**
     * Create customer in CRM module and login customer created
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSingIn(Request $request)
    {
        // optional automatic validate
        // $this->validate($request, [
        //     'name'      => 'required|max:255',
        //     'surname'   => 'required|max:255',
        //     'email'     => 'required|max:255|email|unique:009_301_customer,email_301',
        //     'password'  => 'required|between:4,15|same:repassword',
        // ]);

        // manual validate
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'surname'   => 'required|max:255',
            'email'     => 'required|max:255|email|unique:009_301_customer,email_301',
            'password'  => 'required|between:4,15|same:repassword',
        ]);

        // manage fails
        if ($validator->fails())
        {
            if($request->input('responseType') == 'json')
            {
                return response()->json([
                    'status'    => 'error',
                    'errors'    => $validator->messages()
                ], 422);
            }
            else
            {
                return redirect()
                    ->route('getSingIn-' . user_lang())
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // create new customer
        $customer = CrmLibrary::createCustomer($request);

        // create new contact
        if($request->input('createContact') == '1')
        {
            // create contact on comunik package
            $contact = ComunikLibrary::createContact($request);

            // attach contact to groups that you want, use:
            // <input name="contactGroups[]" value="1">, <input name="contactGroups[]" value="2">, <input name="contactGroups[]" value="3">, etc.
            // to define a input array
            if(($request->has('subscribeEmail') || $request->has('subscribeMobile')) && $request->has('contactGroups') && is_array($request->input('contactGroups')))
                $contact->getGroups()->attach($request->input('contactGroups'));
        }

        // auth the customer created
        Auth::guard('crm')->login($customer);

        $dataMail = $request->all();

        // send email confirmation to customer
        Mail::send('email.content.welcome_email', ['data' => $dataMail], function ($message) use ($dataMail) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($dataMail['email'], $dataMail['name'])->subject('Welcome to ...');
        });

        if($request->input('responseType') == 'json')
        {
            return response()->json([
                'status'    => 'success',
                'customer'  => auth('crm')->user()
            ]);
        }
        else
        {
            return redirect()->route('account-' . user_lang());
        }
    }

    public function putSingIn(Request $request)
    {
        $rules   = [
            'name'      => 'required|max:255',
            'surname'   => 'required|max:255',
            'email'     => 'required|max:255|email|unique:009_301_customer,email_301',
            'password'  => 'required|between:4,15|same:repassword',
        ];

        if($request->input('email') == auth('crm')->user()->email_301)
            $rules['email'] = 'required|max:255|email';

        if(! $request->has('password'))
            $rules['password'] = '';

        // optional automatic validate
        // $this->validate($request, $rules);

        // manual validate
        $validator = Validator::make($request->all(), $rules);

        // manage fails
        if ($validator->fails())
        {
            if($request->input('responseType') == 'json')
            {
                return response()->json([
                    'status'    => 'error',
                    'errors'    => $validator->messages()
                ], 422);
            }
            else
            {
                return redirect()
                    ->route('account-' . user_lang())
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // get old customer
        $oldCustomer = Customer::builder()->find($request->input('id'));

        // update customer
        $customer = CrmLibrary::updateCustomer($request);

        // update password
        if($request->has('password'))
            CrmLibrary::updatePassword($request);

        // update contact if there are email and mobile
        if($request->input('updateContact') == '1' && (! empty($oldCustomer->email_301) || ! empty($oldCustomer->mobile_301)))
        {
            // get contact from old data
            $query = Contact::builder();

            if(! empty($oldCustomer->email_301))
                $query->where('email_041', $oldCustomer->email_301);
            elseif (! empty($oldCustomer->mobile_301))
                $query->where('mobile_041', $oldCustomer->mobile_301);

            $contact = $query->first();

            // overwrite customer id by
            $request->merge(['id' => $contact->id_041]);

            // update contact
            ComunikLibrary::updateContact($request);
        }

        // auth the customer created
        Auth::guard('crm')->login($customer);

        // show message
        $request->session()->flash('customerUpdated', true);

        if($request->input('responseType') == 'json')
        {
            return response()->json([
                'status'    => 'success',
                'customer'  => auth('crm')->user()
            ]);
        }
        else
        {
            return redirect()->route('account-' . user_lang());
        }
    }

    /**
     * Update password from customer
     *
     * @param   Request     $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function putPassword(Request $request)
    {
        CrmLibrary::updatePassword($request);

        return redirect()->route('account-' . user_lang());
    }
}