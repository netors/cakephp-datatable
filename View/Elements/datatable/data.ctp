<?php
foreach ($dataTabledModels as $model) {
    $controller = Inflector::tableize($model);
    foreach($dtResults as $key=>$result) {
        $activateLinks = false;
        foreach ($dtColumns[$model] as $column=>$settings) {
            if ($settings['useField']) {
                $column = str_replace($model.'.','',$column);
                if ($column=='is_active') {
                    $activateLinks = true;
                    $this->dtResponse['aaData'][$key][] = $result[$model][$column]?'<span class="label label-success">'.__('Active').'</span>':'<span class="label label-important">'.__('Inactive').'</span>';
                } else if ($settings['bindModel']) {
                    if ($settings['bindModel']) {
                        if (!array_key_exists('className', $settings)) {
                            $name = substr($column,strlen($column)-3)=='_id'?substr($column,0,strlen($column)-3):$column;
                            $className = Inflector::classify($name);
                            $settings['className'] = $className;
                        }
                        if (array_key_exists('contain', $settings)) {
                            $settings['contain'] = array_merge(array($settings['className']), $settings['contain']);
                        } else {
                            if (!array_key_exists('displayField', $settings)) {
                                // @todo: if displayField is not specified, get it from model..
                                $settings['displayField'] = 'name';
                            }
                            if (!array_key_exists('controller', $settings)) {
                                $settings['controller'] = Inflector::tableize($settings['className']);
                            }
                            if (!array_key_exists('action', $settings)) {
                                // @todo: if action is not specified, use view
                                $settings['action'] = 'view';
                            }
                            if (!array_key_exists('foreignKey', $settings)) {
                                // @todo: if displayField is not specified, get it from model..
                                $settings['foreignKey'] = 'id';
                            }
                            if (!array_key_exists('createLink', $settings)) {
                                $settings['createLink'] = false;
                            }
                            /*
                            $settings['contain'] = array(
                                $settings['className'] => array(
                                    'fields' => array('id', $settings['displayField'])
                                )
                            );
                            */
                            if ($settings['createLink']) {
                                $this->dtResponse['aaData'][$key][] = $this->Html->link($result[$settings['className']][$settings['displayField']], array('controller'=>$settings['controller'],'action'=>$settings['action'],$result[$settings['className']][$settings['foreignKey']]));
                            } else {
                                $this->dtResponse['aaData'][$key][] = $result[$settings['className']][$settings['displayField']];
                            }
                        }
                    }
                } else {
                    $this->dtResponse['aaData'][$key][] = $result[$model][$column];
                }
            } else if (strtolower($column)=='actions') {
                // @todo: assuming primaryKey is always id.. replace id with primaryKey of model
                // @todo: this takes too long to render.., will try to do with js on the client side
                $links = '<div class="btn-group row-actions" data-modelid="'.$result[$model]['id'].'" '.($activateLinks?'data-isactive="'.(@$result[$model]['is_active']?1:0).'"':'').' data-controller="'.$controller.'">';
                //$links .= $this->Html->link(__('View'), array('controller'=>$controller,'action'=>'view', $result[$model]['id']), array('class'=>'btn btn-primary','escape'=>false));
                //$links .= $this->Html->link(__('Edit'), array('controller'=>$controller,'action'=>'edit', $result[$model]['id']), array('class'=>'btn btn-default','escape'=>false));
                //$links .= $this->Html->link(__('Delete'), array('controller'=>$controller,'action'=>'delete', $result[$model]['id']), array('class'=>'btn btn-danger','escape'=>false), __('Are you sure you want to delete %s # %s?', $model, $result[$model]['id']));
                //if ($activateLinks) {
                //$deactivateLink = $this->Form->postLink(__('Deactivate'), array('controller'=>$controller,'action' => 'deactivate', $result[$model]['id']), array('class'=>'btn btn-danger','escape'=>false), __('Are you sure you want to deactivate %s # %s?', $model, $result[$model]['id']));
                //$activateLink = $this->Form->postLink(__('Activate'), array('controller'=>$controller,'action' => 'activate', $result[$model]['id']), array('class'=>'btn btn-success','escape'=>false), __('Are you sure you want to activate %s # %s?', $model, $result[$model]['id']));
                //$links .= $result[$model]['is_active']?$deactivateLink:$activateLink;
                //}
                $links .= '</div>';
                $this->dtResponse['aaData'][$key][] = $links;
            }
        }
    }
}