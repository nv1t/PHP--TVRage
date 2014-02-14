<?php

    /**                                                                         
     * TV Schedule class, get the Schedule for different countries                            
     *                                                                          
     * @package PHP::TVDB                                                       
     * @author nv1t <nuit@hoeja.de>                              
     */     

    class TV_Schedule extends TVRage {

    
        public static function fetch($country = 'US') {
            $params = array('action' => 'get_schedule','country' => $country);
            $data = TVRage::request($params);

            if($data) {
                $xml = simplexml_load_string($data);
                $data = array();
                $temp = array();

                foreach($xml as $dates) {
                    $temp['date'] = (string)$dates['attr'];

                    foreach($dates as $times) {
                        $temp['time'] = (string)$times['attr'];

                        foreach($times as $show) {
                            $temp['name'] = (string)$show['name'];
                            $temp['sid'] = (int)$show->sid;
                            $temp['network'] = (string)$show->network;
                            $temp['ep'] = (string)$show->ep;
                            list($temp['season'], $temp['number']) = array_pad(explode('x', (string)$show->ep, 2), 2, null);
                            $temp['link'] = (string)$show->link;
                            
                            array_push($data,$temp);
                        }
                    }
                }
                return $data;
            }
        }
    }
