<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $accountSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string $friendlyName
 * @property string $sid
 */
class AuthCallsCredentialListMappingInstance extends InstanceResource {
    /**
     * Initialize the AuthCallsCredentialListMappingInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the Account that created the resource
     * @param string $domainSid The unique string that identifies the resource
     * @param string $sid The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $accountSid, string $domainSid, string $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'sid' => Values::array_get($payload, 'sid'),
        ];

        $this->solution = [
            'accountSid' => $accountSid,
            'domainSid' => $domainSid,
            'sid' => $sid ?: $this->properties['sid'],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return AuthCallsCredentialListMappingContext Context for this
     *                                               AuthCallsCredentialListMappingInstance
     */
    protected function proxy(): AuthCallsCredentialListMappingContext {
        if (!$this->context) {
            $this->context = new AuthCallsCredentialListMappingContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['domainSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Fetch a AuthCallsCredentialListMappingInstance
     *
     * @return AuthCallsCredentialListMappingInstance Fetched
     *                                                AuthCallsCredentialListMappingInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): AuthCallsCredentialListMappingInstance {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the AuthCallsCredentialListMappingInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name) {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.AuthCallsCredentialListMappingInstance ' . \implode(' ', $context) . ']';
    }
}