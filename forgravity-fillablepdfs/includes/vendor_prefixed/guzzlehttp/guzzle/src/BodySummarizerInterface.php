<?php

namespace ForGravity\Fillable_PDFs\GuzzleHttp;

use ForGravity\Fillable_PDFs\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message) : ?string;
}
