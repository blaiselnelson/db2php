
	/**
	 * store for old instance after object has been modified
	 *
	 * @var <type>
	 */
	private $oldInstance=null;

	/**
	 * get old instance if this has been modified, otherwise return null
	 *
	 * @return <type>
	 */
	public function getOldInstance() {
		return $this->oldInstance;
	}

	/**
	 * called when the field with the passed id has changed
	 *
	 * @param int $fieldId
	 */
	protected function notifyChanged($fieldId) {
		if (is_null($this->getOldInstance())) {
			$this->oldInstance=clone $this;
			$this->oldInstance->notifyPristine();
		}
	}

	/**
	 * return true if this instance has been modified since the last notifyPristine() call
	 *
	 * @return bool
	 */
	public function isChanged() {
		return !is_null($this->getOldInstance());
	}

	/**
	 * return array with the field ids of values which have been changed since the last notifyPristine call
	 *
	 * @return array
	 */
	public function getFieldsChanged() {
		$changed=array();
		if (!$this->isChanged()) {
			return $changed;
		}
		$old=$this->getOldInstance()->toArray();
		$new=$this->toArray();
		foreach ($old as $fieldId=>$value) {
			if ($new[$fieldId]!==$value) {
				$changed[]=$fieldId;
			}
		}
		return $changed;
	}

	/**
	 * set this instance into pristine state
	 */
	public function notifyPristine() {
		$this->oldInstance=null;
	}
