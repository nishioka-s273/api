<?php

// (c_1 AND c_2 AND c_3)) OR (c_4 AND c_5) を表すBDD

// 変数節点
class vnode{
    public $name;
    public $next0;   // 子ノード (0枝の分岐先)
    public $next1;   // 子ノード (1枝の分岐先)
}

// 定数節点
class snode{
    public $name;
}

class bdd{
    public $v_node; // 変数節点
    public $s_node; // 定数節点
    public $depth;  // 深さ (n段, 定数節点を含まない)
}

// BDD の定義
$az_bdd = new bdd;
// 節点
$c1c = new vnode;
$c21 = new vnode;
$c22 = new vnode;
$c31 = new vnode;
$c32 = new vnode;
$c33 = new vnode; 
$c41 = new vnode;
$c42 = new vnode;
$c43 = new vnode;
$c51 = new vnode;
$c52 = new vnode;
$c53 = new vnode;
$c0 = new snode;
$c1 = new snode;

// 変数節点
$az_bdd->v_node = [[$c1], [$c21, $c22], [$c31, $c32, $c33], [$c41, $c42, $c43], [$c51, $c52, $c53]];
// 定数節点
$az_bdd->s_node = [$c0, $c1];

// 節点の接続状態
// c_1
$c1->name = 11;
$c1->next0 = $c21;
$c1->next1 = $c22;
// c_2 (2-1)
$c21->name = 21;
$c21->next0 = $c31;
$c21->next1 = $c32;
// c_2 (2-2)
$c22->name = 22;
$c22->next0 = $c31;
$c22->next1 = $c33;
// c_3 (3-1)
$c31->name = 31;
$c31->next0 = $c41;
$c31->next1 = $c41;
// c_3 (3-2)
$c32->name = 32;
$c32->next0 = $c42;
$c32->next1 = $c42;
// c_3 (3-3)
$c33->name = 33;
$c33->next0 = $c42;
$c33->next1 = $c43;
// c_4 (4-1)
$c41->name = 41;
$c41->next0 = $c51;
$c41->next1 = $c52;
// c_4 (4-2)
$c42->name = 42;
$c42->next0 = $c51;
$c42->next1 = $c52;
// c_4 (4-3)
$c43->name = 43;
$c43->next0 = $c53;
$c43->next1 = $c53;
// c_5 (5-1)
$c51->name = 51;
$c51->next0 = $c0;
$c51->next1 = $c0;
// c_5 (5-2)
$c52->name = 52;
$c52->next0 = $c0;
$c52->next1 = $c1;
// c_5 (5-3)
$c53->name = 53;
$c53->next0 = $c1;
$c53->next1 = $c1;

// 定数節点
// ０
$c0->name = 0; // 1:dummy, 2:true のオーダー
// 1
$c1->name = 1; // 1:true, 2:dummy のオーダー

// 深さ
$az_bdd->depth = 5;