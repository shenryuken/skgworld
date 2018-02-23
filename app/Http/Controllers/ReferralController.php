<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Baum\Node;

use App\Referral;
use App\User;

class ReferralController extends Controller
{
    

    public function getHierarchy($user_id)
    {
        $user = Referral::where('user_id', $user_id)->first();
        $parent_id = $user->parent_id;

        $descendantsAndSelf = $user->getDescendantsAndSelf()->toArray();;
        $tree = $this->buildTree($descendantsAndSelf, $parent_id);
        
        //return $tree;
        return view('referrals.hierarchy', compact('tree'));
    }

    public function buildTree($elements, $parentId)
    {
        $branch = array();
       
        foreach ($elements as $element) {

            $element['name']     = User::find($element['id'])->username;
            $element['title']    = $this->getRankName($element['id']);
            $element['className']= strtolower($element['rank']);

            if ($element['parent_id'] == $parentId) {

                $children = $this->buildTree($elements, $element['id']);

                if ($children) {
                    $element['children'] = $children;       
                }
                $branch[] = $element;
                
                unset($element);
            }     
        }
        return $branch;
    }

    public function getRankName($id)
    {
        $user = User::find($id);
        $rank_name = $user->rank->name;

        return $rank_name;
    }

    public function getDownline()
    {
        $id   = Auth::user()->id;
        $user = Referral::where('user_id',$id)->first();
        $descendants = $user->getImmediateDescendants();

        // echo "<pre>";
        // var_dump($descendants);
        // echo "</pre>";
        return view('referrals.my-downline', compact('descendants'));
    }

    public function getThreeGenDoGroupMembers()
    {
        //
    }
    
}
