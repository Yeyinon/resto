<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    /**
     * Vérifier si un client peut laisser un commentaire pour un restaurant.
     *
     * @param int $restaurantId
     * @return bool
     */
    private function canLeaveComment($restaurantId)
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return false;
        }
        
        // Chercher les réservations confirmées et honorées de ce client pour ce restaurant
        $honoredReservations = Reservation::where('client_id', $client->id)
            ->whereHas('table', function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->where('status', 'confirmed') // Réservation confirmée
            ->where('reservation_date', '<', Carbon::now()->toDateString()) // Date dans le passé
            ->exists();
            
        return $honoredReservations;
    }
    
    /**
     * Vérifier si le client a déjà commenté ce restaurant
     */
    private function hasAlreadyCommented($restaurantId)
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            return false;
        }
        
        return Comment::where('client_id', $client->id)
            ->where('restaurant_id', $restaurantId)
            ->exists();
    }
    
    /**
     * Afficher le formulaire de commentaire si le client peut commenter
     */
    public function showCommentForm($restaurantId)
    {
        if (!$this->canLeaveComment($restaurantId)) {
            return redirect()->back()->with('error', 'Vous ne pouvez laisser un commentaire qu\'après avoir honoré une réservation confirmée dans ce restaurant.');
        }
        
        if ($this->hasAlreadyCommented($restaurantId)) {
            return redirect()->back()->with('info', 'Vous avez déjà laissé un commentaire pour ce restaurant.');
        }
        
        return view('client.comment_form', ['restaurant_id' => $restaurantId]);
    }
    
    /**
     * Stocker un nouveau commentaire
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Veuillez attribuer une note.',
            'rating.min' => 'La note doit être comprise entre 1 et 5 étoiles.',
            'rating.max' => 'La note doit être comprise entre 1 et 5 étoiles.',
            'content.required' => 'Veuillez écrire un commentaire.',
            'content.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ]);
        
        if (!$this->canLeaveComment($request->restaurant_id)) {
            return redirect()->back()->with('error', 'Vous ne pouvez laisser un commentaire qu\'après avoir honoré une réservation confirmée dans ce restaurant.');
        }
        
        if ($this->hasAlreadyCommented($request->restaurant_id)) {
            return redirect()->back()->with('info', 'Vous avez déjà laissé un commentaire pour ce restaurant.');
        }
        
        $client = Auth::guard('client')->user();
        
        Comment::create([
            'client_id' => $client->id,
            'restaurant_id' => $request->restaurant_id,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);
        
        return redirect()->back()->with('success', 'Merci pour votre commentaire et votre note !');
    }
    
    /**
     * Vérification AJAX si un client peut commenter
     */
    public function checkCanComment($restaurantId)
    {
        $canComment = $this->canLeaveComment($restaurantId);
        $hasCommented = $this->hasAlreadyCommented($restaurantId);
        
        return response()->json([
            'can_comment' => $canComment && !$hasCommented,
            'has_commented' => $hasCommented,
            'message' => $this->getCommentMessage($canComment, $hasCommented)
        ]);
    }
    
    /**
     * Obtenir le message approprié pour l'état du commentaire
     */
    private function getCommentMessage($canComment, $hasCommented)
    {
        if ($hasCommented) {
            return 'Vous avez déjà laissé un commentaire pour ce restaurant.';
        }
        
        if (!$canComment) {
            return 'Vous devez avoir honoré une réservation confirmée dans ce restaurant pour pouvoir laisser un commentaire.';
        }
        
        return 'Vous pouvez laisser un commentaire.';
    }
}