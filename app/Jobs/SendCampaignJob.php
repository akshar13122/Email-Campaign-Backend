<?php

namespace App\Jobs;

use App\Models\CampaignModel;
use App\Models\CampaignRecipientModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable as BusQueueable;

class SendCampaignJob implements ShouldQueue
{
    use BusQueueable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaignId;

    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
        // $this->queue = 'campaign-' . $campaignId;
    }

    public function handle(){
        $campaign = CampaignModel::find($this->campaignId);

        if (!$campaign) {
            return;
        }

        try {

            /* 2 = processing */

            $campaign->status = 2;
            $campaign->save();

            $recipients = CampaignRecipientModel::where(
                'campaign_id',
                $campaign->id
            )
            ->where('status', 0)
            ->get();

            foreach ($recipients as $recipient) {

                try {

                    /* Get email from contact */

                    if (!$recipient->contact || !$recipient->contact->email) {
                        continue;
                    }

                    Mail::raw(
                        $campaign->content,
                        function ($message) use ($campaign, $recipient) {

                            $message->to(
                                $recipient->contact->email
                            )
                            ->subject(
                                $campaign->subject
                            );
                        }
                    );

                    /* 2 = sent */

                    $recipient->status = 2;
                    $recipient->sent_at = now();
                    $recipient->save();

                } catch (\Exception $e) {

                    /* 3 = failed */

                    $recipient->status = 3;
                    $recipient->save();

                    Log::error(
                        "Email failed: " .
                        $recipient->contact->email
                    );
                }
            }

            $remaining = CampaignRecipientModel::where(
                'campaign_id',
                $campaign->id
            )
            ->where('status', 0)
            ->count();

            if ($remaining == 0) {

                /* 3 = completed */

                $campaign->status = 3;
                $campaign->save();
            }

        } catch (\Exception $e) {

            /* 4 = failed */

            $campaign->status = 4;
            $campaign->save();

            Log::error($e->getMessage());
        }
    }
}