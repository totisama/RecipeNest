<?php

test('Partner recipes are fetched', function () {
    $response = $this->get('/partner-recipes');

    $recipesArray = $response->original->getData()['recipes'];

    $response->assertStatus(200);
    $this->assertNotEmpty($recipesArray);
});
