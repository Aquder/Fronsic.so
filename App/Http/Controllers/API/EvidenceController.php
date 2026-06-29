<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use App\Http\Resources\Evidence_Resource;
use App\Models\Evidences;
use App\Models\UseCase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EvidenceController extends Controller {
    public function store( Request $request ): JsonResponse {
        $request->validate( [
            'name'       => 'required|string|max:255',
            'case_id'    => 'required|exists:use_cases,id',
            'data'       => 'required|array',
        ] );
        $case = UseCase::where( 'user_id', Auth::id() )->find( $request->case_id );
        if ( !$case ) {
            return response()->json( [ 'status' => false, 'message' => 'error ! use case is not found ' ], 403 );
        }
        $evidence = $case->evidences()->create( [
            'name'       => $request->name,
            'case_id'    => $request->case_id,
            'data'       => $request->data,
        ] );
        return response()->json( [
            'status'  => 'success',
            'message' => 'Evidence stored successfully.',
            'evidence' => $evidence
        ], 201 );
    }

    public function update( Request $request, $evidence_id, $case_id ): JsonResponse {
        $case = UseCase::where( 'user_id', Auth::id() )->find( $case_id );
        if ( !$case ) {
            return response()->json( [ 'status' => false, 'message' => 'error ! use case is not found ' ], 403 );
        }
        $evidence = $case->evidences()->find( $evidence_id );
        if ( !$evidence ) {
            return response()->json( [
                'status' => false,
                'msg' => 'error evidence is not found ',
                'evidence' => null
            ], 201 );
        }
        $validated = $request->validate( [
            'name' => 'required|string|min:3',
        ] );
        $evidence->update( [ 'name'=>$request->name ] );
        return response()->json( [
            'status' => true,
            'msg' => 'updated evidence successfully',
            'evidence' => new Evidence_Resource( $evidence ),
        ], 201 );
    }

    public function destroy( $evidence_id, $case_id ) {
        $case = UseCase::where( 'user_id', Auth::id() )->find( $case_id );
        if ( !$case ) {
            return response()->json( [ 'status' => false, 'message' => 'error ! use case is not found ' ], 403 );
        }
        $evidence = $case->evidences()->find( $evidence_id );
        if ( !$evidence ) {
            return response()->json( [
                'status' => false,
                'msg' => 'error evidence is not found ',
                'evidence' => null
            ], 201 );
        }
        $evidence->delete();
        return response()->json( [
            'status' => true,
            'msg' => 'deleted evidence successfully',
        ], 201 );

    }

    public function upload( Request $request ): JsonResponse {
        $request->validate( [
            'name'       => 'required|string|max:255',
            'case_id'    => 'required|exists:use_cases,id',
            'model_used'    => 'required',
        ], [
            'model_used.required'=>'model used it must be between this [ deep fake - face recogantion -]'
        ] );
        $case = UseCase::where( 'user_id', Auth::id() )->find( $request->case_id );
        if ( !$case ) {
            return response()->json( [ 'status' => false, 'message' => 'error ! use case is not found ' ], 403 );
        }

        $data = null;
        if ( $request->model_used === 'deep fake' ) {
            $controller = new DeepFakeController();
            $data = $controller->store( $request );
        } elseif ( $request->model_used === 'face recognation' ) {
            $controller = new FaceRecogController();
            $data = $controller->store( $request );
        }
        //  elseif ( $request->model_used === 'face reconstruction' ) {
        //     $controller = new FacePredictionController();
        //     $data = $controller->processFace( $request );
        // }elseif ( $request->model_used === 'dna analysis' ) {
        //     $controller = new DnaController();
        //     $data = $controller->processSequence( $request );
        // }
        else {
            return response()->json( [
                'status'  => 'false',
                'message' => ' please value of model name do not match with system ,it must be models system ',
                'names model system ' => [
                    'deep fake',
                    'face recogantion',
                    'face reconstruction',
                    'dna analysis',
                 ],
            ], 400 );
        }

        $evidence = $case->evidences()->create( [
            'name'       => $request->name,
            'case_id'    => $request->case_id,
            'data'       => $data,
        ] );
        return response()->json( [
            'status'  => 'success',
            'message' => 'Evidence uploaded successfully.',
            'evidence' => $evidence
        ], 201 );
    }

}
