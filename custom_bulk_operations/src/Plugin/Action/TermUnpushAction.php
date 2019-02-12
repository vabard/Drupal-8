<?php

namespace Drupal\custom_bulk_operations\Plugin\Action;

use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'TermUnpushAction' action.
 *
 * @Action(
 *  id = "term_unpush_action",
 *  label = @Translation("Term unpush action"),
 *  type = "taxonomy_term",
 *  confirm = TRUE,
 * )
 */
class TermUnpushAction extends ViewsBulkOperationsActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    if ($entity !== NULL && $entity->hasField('field_push')) {
      $entity->field_push->value = 0;
      $entity->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    $result = $object->access('update', $account, TRUE)
      ->andIf($object->field_push->access('edit', $account, TRUE));

    return $return_as_object ? $result : $result->isAllowed();
  }
}
