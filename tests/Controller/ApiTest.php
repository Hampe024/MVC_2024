<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\Game;
use App\Controller\Api;

use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiControllerTest extends WebTestCase
{
    public function testApiQuote()
    {
        $client = static::createClient();

        $client->request('GET', '/api/quote');

        $this->assertResponseIsSuccessful();

        $res = $client->getResponse()->getContent();

        $this->assertJson($res);

        $responseData = json_decode($res, true);
        $this->assertIsArray($responseData);
        $this->assertCount(3, $responseData);
    }

    public function testDeck()
    {
        $deck = new DeckOfCards();

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
                ->method('has')
                ->willReturn(true);
        $session->expects($this->once())
                ->method('get')
                ->with('deck')
                ->willReturn($deck);

        $api = new Api();
        $result = json_decode($api->apiDeck($session)->getContent(), true);

        $cardsInDeck = $deck->getDeckAsString();

        $this->assertsame($cardsInDeck, $result["deck"]);
    }

    public function testDeckShuffle()
    {
        $deckMock = $this->createMock(DeckOfCards::class);
        $deckMock->expects($this->once())
                ->method('getDeckAsString')
                ->willReturn(["worked!"]);

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
                ->method('has')
                ->willReturn(true);
        $session->expects($this->once())
                ->method('get')
                ->with('deck')
                ->willReturn($deckMock);

        $api = new Api();
        $result = json_decode($api->apiDeckShuffle($session)->getContent(), true);


        $this->assertSame($result["deck"], ["worked!"]);
    }

    public function testDeckDraw()
    {
        $cardMock = $this->createMock(Card::class);
        $cardMock->expects($this->once())
                ->method('getAsString')
                ->willReturn("worked!");

        $deckMock = $this->createMock(DeckOfCards::class);
        $deckMock->expects($this->once())
                ->method('drawCard')
                ->willReturn($cardMock);

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
                ->method('has')
                ->willReturn(true);
        $session->expects($this->once())
                ->method('get')
                ->with('deck')
                ->willReturn($deckMock);

        $api = new Api();
        $result = json_decode($api->apiDeckDraw(1, $session)->getContent(), true);


        $this->assertSame($result["cards"][0], "worked!");
    }

    public function testGame()
    {
        $cardMock = $this->createMock(Card::class);
        $cardMock->expects($this->once())
                ->method('getAsString')
                ->willReturn("worked!");

        $game = new Game();

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->exactly(4))
                ->method('has')
                ->withConsecutive(['game'], ['playerPlaying'], ['ace'], ['winner'])
                ->willReturnOnConsecutiveCalls(true, true, true, true);

        $session->expects($this->exactly(4))
                ->method('get')
                ->withConsecutive(['game'], ['playerPlaying'], ['ace'], ['winner'])
                ->willReturnOnConsecutiveCalls($game, false, $cardMock, "we are all winners :)");

        $api = new Api();
        $result = json_decode($api->apiGame($session)->getContent(), true);

        $expectedData = [
            "playerPlaying" => false,
            "player_hand" => $game->player->getHandAsString(),
            "player_hand_amount" => $game->player->getAmountOfCards(),
            "player_hand_value" => $game->player->getValueAsArr(),
            "dealer_hand" => $game->dealer->getHandAsString(),
            "dealer_hand_amount" => $game->dealer->getAmountOfCards(),
            "dealer_hand_value" => $game->dealer->getValueAsArr(),
            "ace" => "worked!",
            "winner" => "we are all winners :)"
        ];

        $this->assertSame($result, $expectedData);
    }

    // public function testLibraryBooks()
    // {
    //     $book = [
    //         "id" => 1,
    //         "title" => "a good title",
    //         "ISBN" => "1234567890",
    //         "author" => "me",
    //         "imgULR" => "linkToImg"
    //     ];

    //     $libraryMock = $this->createMock(LibraryRepository::class);
    //     $libraryMock->expects($this->once())
    //             ->method('findAll')
    //             ->willReturn([$book]);

    //     $api = new Api();
    //     $result = json_decode($api->apiLibraryBooks($libraryMock)->getContent(), true);

    //     $this->assertSame($result, [$book]);
    // }

}
