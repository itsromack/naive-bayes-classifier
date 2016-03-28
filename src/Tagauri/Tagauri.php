<?php
namespace Natividad\Tagauri;

use Fieg\Bayes\Classifier;
use Fieg\Bayes\Tokenizer\WhitespaceAndPunctuationTokenizer;
use Keboola\Csv\CsvFile;
use \Exception;

class Tagauri
{
	private $tokenizer;
	private $classifier;
	private $trainingData;

	public function __construct($trainingFile = null)
	{
		$this->tokenizer = new WhitespaceAndPunctuationTokenizer();
		$this->classifier = new Classifier($this->tokenizer);
		if (!is_null($trainingFile))
		{
			$this->trainingData = new CsvFile($trainingFile);
		}
	}

	/**
	 * Train the classifier
	 * @param String $trainingFile
	 */
	public function sanayin($trainingFile = null)
	{
		if (!is_null($trainingFile))
		{
			$this->trainingData = new CsvFile($trainingFile);
		}

		if (is_null($this->trainingData))
		{
			throw new Exception('The training data is empty');
		}
		else
		{
			foreach ($this->trainingData as $row) {
				$category = $row[0];
				$data = $row[1];
				$this->classifier->train($category, $data);
			}
		}
	}

	/**
	 * Classify a text
	 * @param String $data - string that would be classified
	 * @return String or boolean
	 */
	public function uriin($data)
	{
		if (is_null($this->trainingData))
		{
			throw new Exception('The training data is empty');
		}
		else
		{
			// initialize vars
			$maxPoints = 0;
			$assumedCategory = null;
			$result = $this->classifier->classify($data);
			foreach ($result as $category => $points)
			{
				$percentage = ($points * 100);
				if ($percentage > $maxPoints)
				{
					$maxPoints = $percentage;
					$assumedCategory = $category;
				}
			}

			return $assumedCategory;
		}

		return false;
	}
}