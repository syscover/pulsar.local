<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Syscover\Market\Libraries\CouponLibrary;
use Syscover\Market\Models\CartPriceRule;
use Syscover\Market\Models\Product;
use Syscover\Market\Models\TaxRule;
use Syscover\Pulsar\Models\Attachment;
use Syscover\ShoppingCart\Exceptions\ShoppingCartNotCombinablePriceRuleException;
use Syscover\ShoppingCart\PriceRule;
use Syscover\ShoppingCart\TaxRule as TaxRuleShoppingCart;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\ShoppingCart\Item;

/**
 * Class ShoppingCartController
 * @package App\Http\Controllers
 */

class ShoppingCartController extends Controller
{
    /**
     * Show shopping cart
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShoppingCart(Request $request)
    {
        // get cart items from shoppingCart
        $response['cartItems'] = CartProvider::instance()->getCartItems();

        return view('www.content.shopping_cart', $response);
    }

    /**
     * Función que añade un producto al carro de compra
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postShoppingCart(Request $request)
    {
        // get parameters from url route
        $parameters = $request->route()->parameters();

        $product = Product::builder()
            ->where('lang_id_112', user_lang())
            ->where('slug_112', $parameters['slug'])
            ->where('active_111', true)
            ->first();

        // get image to shopping cart
        $attachment = Attachment::builder()
            ->where('lang_id', user_lang())
            ->where('resource_id', 'market-product')
            ->where('family_id', config('www.attachmentsFamily.productSheet'))
            ->where('object_id', $product->id_111)
            ->first();

        // create a property on product to save image for shopping cart list
        $product->shoppingCartImage = $attachment;

        // get tax rule with default parameters
        $taxRules = TaxRule::builder()
            ->where('country_id_103', config('market.taxCountry'))
            ->where('customer_class_tax_id_106', config('market.taxCustomerClass'))
            ->where('product_class_tax_id_107', $product->product_class_tax_id_111)
            ->orderBy('priority_104', 'asc')
            ->get();

        // create taxRule with format for shopping cart
        $taxRulesShoppingCart = [];
        foreach ($taxRules as $taxRule)
        {
            $taxRulesShoppingCart[] = new TaxRuleShoppingCart(
                Lang::has($taxRule->translation_104) ? trans($taxRule->translation_104) : $taxRule->name_104,
                $taxRule->tax_rate_103,
                $taxRule->priority_104,
                $taxRule->sort_order_104
            );
        }

        //**************************************************************************************
        // Know if product is transportable
        // Options:
        // 1 - downloadable
        // 2 - transportable
        // 3 - transportable_downloadable
        // 4 - service
        //
        // You can change this value, if you have same product transportable and downloadable
        //
        //***************************************
        $isTransportable = $product->type_id_111 == 2 || $product->type_id_111 == 3? true : false;


        // when get price from product, internally calculate subtotal and total.
        // we don't want save this object on shopping cart, if login user with different prices and add same product, will be different because the product will have different prices
        $optionsProduct = $product;

        try
        {
            // intance row to add product
            CartProvider::instance()->add(
                new Item(
                    $product->id_111,
                    $product->name_112,
                    1,
                    $product->price_111,
                    $product->weight_111,
                    $isTransportable,
                    $taxRulesShoppingCart,
                    [
                        'product' => $optionsProduct
                    ]
                )
            );
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
        
        return redirect()->route('getShoppingCart-' . user_lang());
    }

    /**
     * Update shopping cart quantity and apply coupon code, this method is call from shopping cart view
     *
     * @param   Request     $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putShoppingCart(Request $request)
    {
        // check idf exist coupon code
        if($request->has('applyCouponCode'))
        {
            CouponLibrary::addCouponCode(CartProvider::instance(), $request->input('applyCouponCode'), user_lang(), auth('crm'));
        }

        $cartItems = CartProvider::instance()->getCartItems();

        foreach($cartItems as $item)
        {
            if(is_numeric($request->input($item->rowId)))
            {
                CartProvider::instance()->setQuantity($item->rowId, (int)$request->input($item->rowId));
            }
        }

        return redirect()->route('getShoppingCart-' . user_lang());
    }

    public function deleteShoppingCart(Request $request)
    {
        // get parameters from url route
        $parameters = $request->route()->parameters();

        CartProvider::instance()->remove($parameters['rowId']);

        return redirect()->route('getShoppingCart-' . user_lang());
    }

    /**
     * Check if coupon code is correct
     *
     * @param   Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function checkCouponCode(Request $request)
    {
        return response()
            ->json(CouponLibrary::checkCouponCode($request->input('couponCode'), user_lang(), auth('crm')));
    }
}