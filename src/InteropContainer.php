<?php
namespace King23\DI\Interop;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;
use King23\DI\DependencyContainer;

/**
 * this is a a bit of a cheat wrapper, as it makes the King23\DI have the methods of the Interopt\Containerinterface
 * but its actually a bit messy to do it this way - as the King23\DI is supposed to use interface names as id's, which
 * the interface is not. It will still work though
 *
 * implementing the ContainerInterface here, also implements the Psr\Container\ContainerInterface
 *
 */
class InteropContainer extends DependencyContainer implements ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */

    public function get($id)
    {
        try {
            return $this->getInstanceOf($id);
        } catch (\King23\DI\Exception\NotFoundException $e) {

            // convert exception to interface compatible exception
            throw new \King23\DI\Interop\NotFoundException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return $this->hasServiceFor($id) || class_exists($id, true);
    }
}
