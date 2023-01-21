<?php

namespace Tests\Feature\Packages\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Packages\Cart\Infrastructure\CartRepository;
use App\Packages\Cart\Infrastructure\ProductFactory;
use App\Packages\Cart\Usecase\CartData;
use App\Packages\Cart\Usecase\CartProductAddAction;
use App\Packages\Cart\Usecase\CartProductAddCommand;
use App\Packages\Shared\Infrastructure\InfrastructureException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartProductAddActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_商品の追加()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $cartProductAddCommand = new CartProductAddCommand($cart->id, $product->id, 1);
        $cartProductAddAction = new CartProductAddAction(new CartRepository(), new ProductFactory());
        $cartData = $cartProductAddAction($cartProductAddCommand);

        $this->assertInstanceOf(CartData::class, $cartData);
        $this->assertDatabaseHas(
            'carts',
            [
                'id' => $cart->id,
            ]
        );

        $this->assertDatabaseHas(
            'cart_products',
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price_with_tax' => $product->price_with_tax,
                'product_tax' => $product->tax,
                'product_point_price' => $product->point_price,
                'product_quantity' => 1
            ]
        );
    }

    public function test__存在しない商品の追加()
    {
        $cart = Cart::factory()->create();

        $cartProductAddCommand = new CartProductAddCommand($cart->id, 1, 1);
        $cartProductAddAction = new CartProductAddAction(new CartRepository(), new ProductFactory());

        $this->expectException(InfrastructureException::class);
        $this->expectExceptionMessage('商品が見つかりませんでした');
        $cartProductAddAction($cartProductAddCommand);
    }

    public function test_既存商品の数量追加()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        $cartProductAddCommand1 = new CartProductAddCommand($cart->id, $product->id, 1);
        $cartProductAddCommand2 = new CartProductAddCommand($cart->id, $product->id, 2);

        $cartProductAddAction = new CartProductAddAction(new CartRepository(), new ProductFactory());
        $cartProductAddAction($cartProductAddCommand1);
        $cartProductAddAction($cartProductAddCommand2);

        $this->assertDatabaseHas(
            'cart_products',
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price_with_tax' => $product->price_with_tax,
                'product_tax' => $product->tax,
                'product_point_price' => $product->point_price,
                'product_quantity' => 3
            ]
        );
    }

}
