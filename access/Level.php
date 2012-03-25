<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace gordian\reefknot\access;

/**
 * Simple access level access control model
 * 
 * This class implements a basic level-based access control system.  The 
 * consumer and resource are each assigned a level, the consumer's level sets
 * the access level the consumer has and the resource's level determines the
 * access level the resource is required to have to be able to access it.  
 * 
 * This is a very simple access control model and therefore easy to understand,
 * but it is limited in the amount of control you can have.  A consumer with a
 * particular access level will always have access to any resource with a lower
 * or equal access level.  For this reason it is recommended that you use this
 * access control model only when porting legacy applications that use the same
 * model to the framework.  
 *
 * @author gordonmcvey
 */
class Level extends abstr\Access
{
}
