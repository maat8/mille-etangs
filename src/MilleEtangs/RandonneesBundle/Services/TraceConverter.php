<?php

namespace MilleEtangs\RandonneesBundle\Services;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

use Doctrine\MongoDB\GridFSFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symm\Gisconverter\Gisconverter;
use MilleEtangs\RandonneesBundle\Document\Trace;
use MilleEtangs\RandonneesBundle\Document\Point;

/**
 * @Service("trace_converter")
 */
class TraceConverter
{
    private $dm;

    private $file;
    private $gpx;
    private $kml;
    private $start;

    /**
     * @DI\InjectParams({
     *     "dm" = @DI\Inject("doctrine.odm.mongodb.document_manager")
     * })
     */
    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function getGpx()
    {
        return $this->gpx;
    }

    public function getKml()
    {
        return $this->kml;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function generateTracesFromFile(UploadedFile $file)
    {
        $this->file = $file;
        $type = $file->getClientOriginalExtension();

        switch($type) {
            case 'gpx':
                $this->gpx = new Trace();
                $this->gpx->setFile($this->file->getPathName());
                $this->dm->persist($this->gpx);
                // Do not flush here : we could be setting gpx/kml itineary fields
                $this->generateKmlFromGpx();
                break;
            case 'kml':
                break;
            default:
                throw \Exception("Format not supported");
        }
    }

    public function generateKmlFromGpx()
    {
        $kml = Gisconverter::gpxToKml(file_get_contents($this->file));
        if (!empty($kml)) {
            /*$kml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                        '<kml xmlns="http://www.opengis.net/kml/2.2">
                            <Document>
                            <name></name>
                            <description>c</description>
                            <Style id="greenLine">
                              <LineStyle>
                                <color>31987bff</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Placemark>
                                <name>Name</name>
                                <description>Description</description>
                                <styleUrl>#greenLine</styleUrl>' .
                        $kml .
                        '   </Placemark>
                        </Document>
                        </kml>';*/

            // Generate KML file content
            $kml = simplexml_load_string(
                '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                '<kml>
                    <Document>
                    <name></name>
                    <description>c</description>
                    <Style id="greenLine">
                      <LineStyle>
                        <color>31987bff</color>
                        <width>4</width>
                      </LineStyle>
                    </Style>
                    <Placemark>
                        <name>Name</name>
                        <description>Description</description>
                        <styleUrl>#greenLine</styleUrl>' .
                $kml .
                '   </Placemark>
                </Document>
                </kml>'
            );

            $this->kml = new Trace();
            $kml_file = new GridFSFile();
            $kml_file->setBytes($kml->asXML());
            $this->kml->setFile($kml_file);

            // $trace  = simplexml_load_file($this->file);

            // Get start point
            $lineString = $kml->xpath("//kml/Document/Placemark/LineString/coordinates");
            list($points) = explode(" ", $lineString[0]->__toString());
            $points = explode(",", $points);
            $this->start = new Point(
                (float) $points[0],
                (float) $points[1]
            );

            // Add xmlns="http://www.opengis.net/kml/2.2"
        }
    }

    public function generateGpxFromKml()
    {
        throw new \Exception("GPX to KML conversion not supported yet");
    }
}
