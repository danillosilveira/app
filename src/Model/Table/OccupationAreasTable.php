<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OccupationAreas Model
 *
 * @property \App\Model\Table\SellersTable|\Cake\ORM\Association\BelongsTo $Sellers
 *
 * @method \App\Model\Entity\OccupationArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\OccupationArea newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OccupationArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OccupationArea|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OccupationArea|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OccupationArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OccupationArea[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OccupationArea findOrCreate($search, callable $callback = null, $options = [])
 */
class OccupationAreasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('occupation_areas');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->decimal('latitude')
            ->allowEmpty('latitude');

        $validator
            ->decimal('longitude')
            ->allowEmpty('longitude');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['seller_id'], 'Sellers'));

        return $rules;
    }
}
