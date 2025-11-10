<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TutorialCompletion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF; // Will use for certificate generation

class TutorialController extends Controller
{
    /**
     * Show the tutorial for a specific product
     */
    public function show(Product $product, Request $request)
    {
        $user = auth()->user();
        
        // Check if user has purchased this product
        $hasPurchased = $user->orders()
            ->where('status', 'completed')
            ->where('product_id', $product->id)
            ->exists();
            
        if (!$hasPurchased && !$user->is_admin) {
            return redirect()->route('products.show', $product->id)
                ->with('error', 'You must purchase this training to access it.');
        }
        
        // Check if already completed
        $completion = TutorialCompletion::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
        
        // Determine which tutorial to show based on request or product content
        $tutorialName = $request->query('tutorial', 'Field Technician Training');
        
        // Map tutorial names to component names
        $tutorialComponents = [
            'Field Technician Training' => 'Tutorial/FieldTechTraining',
            'Cat 6 Cable Installation' => 'Tutorial/Cat6CableTraining',
        ];
        
        $component = $tutorialComponents[$tutorialName] ?? 'Tutorial/FieldTechTraining';
        
        return Inertia::render($component, [
            'product' => $product,
            'hasCompleted' => $completion !== null,
            'certificate' => $completion,
        ]);
    }
    
    /**
     * Mark tutorial as complete
     */
    public function complete(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'answers' => 'required|array',
        ]);
        
        $user = auth()->user();
        
        // Calculate score based on quiz answers
        $correctAnswers = 0;
        $totalQuestions = count($validated['answers']);
        
        foreach ($validated['answers'] as $answer) {
            if ($answer['correct']) {
                $correctAnswers++;
            }
        }
        
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        
        // Create or update completion record
        TutorialCompletion::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $validated['product_id'],
            ],
            [
                'quiz_answers' => $validated['answers'],
                'score' => $score,
                'completed_at' => now(),
            ]
        );
        
        return redirect()->back()->with('success', 'Congratulations! Tutorial completed successfully.');
    }
    
    /**
     * Generate and download certificate
     */
    public function certificate(Product $product)
    {
        $user = auth()->user();
        
        $completion = TutorialCompletion::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
            
        if (!$completion) {
            return redirect()->back()->with('error', 'You must complete the tutorial first.');
        }
        
        // Return certificate view that can be printed/saved as PDF
        return view('certificates.field-tech-training', [
            'user' => $user,
            'product' => $product,
            'completion' => $completion,
        ]);
    }
}
