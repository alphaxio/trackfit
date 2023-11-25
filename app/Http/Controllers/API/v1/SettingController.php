<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\SettingContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\TicketCommentRequest;
use App\Http\Requests\Setting\TicketRequest;
use App\Http\Resources\v1\InquiryResource;
use App\Http\Resources\v1\JsonResponseResource;
use App\Http\Resources\v1\TicketResource;
use App\Traits\ApiResponses;
use Auth;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponses;

    public function __construct(
        private SettingContract $settingService,
    ) {
    }

    public function inquiry()
    {
        try {
            $inquiry = $this->settingService->getInquiry();

            $message = 'Inquiries Fetched Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'inquiries' => InquiryResource::collection($inquiry),

            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function ticketList() {
        try {
            $ticket = $this->settingService->getTicketList();

            $message = 'Tickets Fetched Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'tickets' => TicketResource::collection($ticket),

            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function ticket($ticket_id) {
        try {
            $ticket = $this->settingService->checkTicket($ticket_id);

            if($ticket === null){
                return $this->errorApiResponse('Ticket Not Found', 400);
            }

            $message = 'Ticket Fetched Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'ticket' => new TicketResource($ticket),

            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function submitTicket(TicketRequest $request)
    {
        try {
            $user = Auth::user();

            $ticket = $this->settingService->storeTicket(
                $user,
                $request->inquiry_id,
                $request->title,
                $request->content,
            );
            return $this->okayApiResponse([
                "message" => "Ticket Created Successfully",
                "ticket" =>  new TicketResource($ticket),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }


    public function ticketComment(TicketCommentRequest $request, $ticket_id)
    {
        try {
            $user = Auth::user();
            $ticket = $this->settingService->checkTicket($ticket_id);

            if($ticket === null){
                return $this->errorApiResponse('Ticket Not Found', 400);
            }

            $ticket = $this->settingService->storeTicketComment(
                $ticket,
                $user,
                $request->content,
            );

            return $this->okayApiResponse([
                "message" => "Ticket Comment Added Succssfully",
                "ticket" =>  new TicketResource($ticket),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }

    public function faqs()
    {
        try {

            $faqs = $this->settingService->getFaqs();

            if($faqs->isEmpty()) return $this->errorApiResponse('No Term Of Use', 404);

            return $this->okayApiResponse([
                "message" => "FAQS Fetched Successfully",
                "faqs" =>  new JsonResponseResource($faqs),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }


    public function terms()
    {
        try {

            $terms = $this->settingService->getTerms();

            if(!$terms) return $this->errorApiResponse('No Term Of Use Found', 404);

            return $this->okayApiResponse([
                "message" => "Terms Fetched Successfully",
                "terms" =>  new JsonResponseResource($terms),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }


    public function policies()
    {
        try {

            $policies = $this->settingService->getPolicies();

            if(!$policies) return $this->errorApiResponse('No Policy Found', 404);

            return $this->okayApiResponse([
                "message" => "Policy Fetched Successfully",
                "policies" =>  new JsonResponseResource($policies),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }



    public function contacts()
    {
        try {

            $contacts = $this->settingService->getContact();

            if(!$contacts) return $this->errorApiResponse('No Contact Found', 404);

            return $this->okayApiResponse([
                "message" => "Contacts Fetched Successfully",
                "contacts" =>  new JsonResponseResource($contacts),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }



    public function deleteAccount()
    {
        $user = auth()->user();
        $user->delete();

        return $this->successNoDataApiResponse('Your Account has been deleted');
    }

}
