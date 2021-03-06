<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersHasUsers Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UsersHasUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersHasUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersHasUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersHasUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersHasUser|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersHasUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersHasUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersHasUser findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersHasUsersTable extends Table
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

        $this->setTable('users_has_users');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'friend_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'friend_id',
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
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['friend_id'], 'Users'));

        return $rules;
    }

    public function findConnection(Query $query, array $options)
    {
        $userId = $options['user_id'];
        $friendId = $options['friend_id'];

        return $query->where([
                'user_id' => $userId,
                'friend_id' => $friendId
            ])
            ->orWhere([
                'friend_id' => $userId,
                'user_id' => $friendId
            ])
            ->first();
    }
}
