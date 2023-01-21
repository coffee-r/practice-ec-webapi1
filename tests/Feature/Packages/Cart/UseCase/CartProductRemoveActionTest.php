<?php

namespace Tests\Feature\Packages\Cart;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Packages\Cart\Infrastructure\CartRepository;
use App\Packages\Cart\Usecase\CartData;
use App\Packages\Cart\Usecase\CartProductRemoveAction;
use App\Packages\Cart\Usecase\CartProductRemoveCommand;
use App\Packages\Shared\Usecase\UsecaseException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartProductRemoveActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_商品削除()
    {
        $cart = Cart::factory()->create();
        $cartProduct1 = CartProduct::factory()->create(['cart_id' => $cart->id, 'product_id' => 1]);
        $cartProduct2 = CartProduct::factory()->create(['cart_id' => $cart->id, 'product_id' => 2]);

        $cartProductRemoveCommand = new CartProductRemoveCommand($cart->id, 1);
        $cartProductRemoveAction = new CartProductRemoveAction(new CartRepository());
        $cartData = $cartProductRemoveAction($cartProductRemoveCommand);

        $this->assertInstanceOf(CartData::class, $cartData);
        $this->assertDatabaseMissing(
            'cart_products',
            [
                'cart_id' => $cart->id,
                'product_id' => 1
            ]
        );
        $this->assertDatabaseHas(
            'cart_products',
            [
                'cart_id' => $cart->id,
                'product_id' => 2
            ]
        );
    }

    public function test__存在しないカートから商品を削除()
    {
        $cartProductRemoveCommand = new CartProductRemoveCommand(1, 1);
        $cartProductRemoveAction = new CartProductRemoveAction(new CartRepository());

        $this->expectException(UsecaseException::class);
        $this->expectExceptionMessage('存在しないカートです');
        $cartData = $cartProductRemoveAction($cartProductRemoveCommand);
    }

}
