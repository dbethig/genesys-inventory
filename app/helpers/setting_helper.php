<?php
$setting_ranges = [
	'engaged',
	'short',
	'medium',
	'long',
	'extreme'
];
$setting_item_conditions = [
	'minor damage',
	'moderate damage',
	'major damage',
	'broken'
];
$setting['generic'] = [
	'skill' => ['Alchemy', 'Arcana', 'Astrocartography', 'Athletics', 'Brawl', 'Charm', 'Coercion', 'Computers', 'Cool', 'Coordination', 'Deception', 'Discipline', 'Divine', 'Driving', 'Gunnery', 'Knowledge', 'Leadership', 'Mechanics', 'Medicine', 'Melee', 'Melee (Heavy)', 'Melee (Light)', 'Negotiation', 'Operating', 'Perception', 'Piloting', 'Primal', 'Ranged', 'Ranged (Heavy)', 'Ranged (Light)', 'Resilience', 'Riding', 'Skulduggery', 'Stealth', 'Streetwise', 'Survival', 'Vigilance'],
	'materials' => false,
	'craftsmanship' => false,
	'range' => $setting_ranges,
	'itemConditions' => $setting_item_conditions
];
// Terrinoth setting skills
$setting['terrinoth'] = [
		'skill' => [
			'Alchemy',
			'Arcana',
			'Athletics',
			'Brawl',
			'Charm',
			'Coercion',
			'Cool',
			'Coordination',
			'Deception',
			'Discipline',
			'Divine',
			'Knowledge (Adventuring)',
			'Knowledge (Forbidden)',
			'Knowledge (Geography)',
			'Knowledge (Lore)',
			'Leadership',
			'Mechanics',
			'Medicine',
			'Melee (Heavy)',
			'Melee (Light)',
			'Negotiation',
			'Perception',
			'Primal',
			'Ranged',
			'Resilience',
			'Riding',
			'Runes',
			'Skulduggery',
			'Stealth',
			'Streetwise',
			'Survival',
			'Vigilance',
			'Verse'
		],
		'material' => [
			'Bone',
			'Hazel',
			'Oak',
			'Willow',
			'Yew'
		],
		'craftsmanship' => [
			'Ancient',
			'Dwarven',
			'Elven',
			'Iron',
			'Steel'
		],
		'range' => $setting_ranges,
		'itemConditions' => $setting_item_conditions
];
define('SETTING', $setting);
